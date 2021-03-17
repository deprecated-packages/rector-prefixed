<?php

declare (strict_types=1);
namespace Rector\Core\PhpParser\NodeTraverser;

use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use Rector\Core\Application\ActiveRectorsProvider;
use Rector\Core\Configuration\Configuration;
use Rector\Core\Contract\Rector\PhpRectorInterface;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Testing\Application\EnabledRectorClassProvider;
final class RectorNodeTraverser extends \PhpParser\NodeTraverser
{
    /**
     * @var PhpRectorInterface[]
     */
    private $allPhpRectors = [];
    /**
     * @var EnabledRectorClassProvider
     */
    private $enabledRectorClassProvider;
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var bool
     */
    private $areNodeVisitorsPrepared = \false;
    /**
     * @param \Rector\Testing\Application\EnabledRectorClassProvider $enabledRectorClassProvider
     * @param \Rector\Core\Configuration\Configuration $configuration
     * @param \Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider
     * @param \PhpParser\NodeFinder $nodeFinder
     * @param \Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider
     */
    public function __construct($enabledRectorClassProvider, $configuration, $activeRectorsProvider, $nodeFinder, $currentFileInfoProvider)
    {
        /** @var PhpRectorInterface[] $phpRectors */
        $phpRectors = $activeRectorsProvider->provideByType(\Rector\Core\Contract\Rector\PhpRectorInterface::class);
        $this->allPhpRectors = $phpRectors;
        $this->enabledRectorClassProvider = $enabledRectorClassProvider;
        $this->nodeFinder = $nodeFinder;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
        $this->configuration = $configuration;
    }
    /**
     * @return Node[]
     * @param \Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode
     */
    public function traverseFileNode($fileNode) : array
    {
        $this->prepareNodeVisitors();
        if ($this->enabledRectorClassProvider->isConfigured()) {
            $this->activateEnabledRectorOnly();
        }
        if (!$this->hasFileNodeRectorsEnabled()) {
            return [];
        }
        // here we only traverse file node without children, to prevent duplicatd traversion
        foreach ($this->visitors as $rector) {
            $rector->enterNode($fileNode);
        }
        return [];
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function traverse(array $nodes) : array
    {
        $this->prepareNodeVisitors();
        if ($this->enabledRectorClassProvider->isConfigured()) {
            $this->activateEnabledRectorOnly();
        }
        $hasNamespace = (bool) $this->nodeFinder->findFirstInstanceOf($nodes, \PhpParser\Node\Stmt\Namespace_::class);
        if (!$hasNamespace && $nodes !== []) {
            $fileWithoutNamespace = new \Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace($nodes);
            $fileWithoutNamespace->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $this->currentFileInfoProvider->getSmartFileInfo());
            return parent::traverse([$fileWithoutNamespace]);
        }
        return parent::traverse($nodes);
    }
    public function getPhpRectorCount() : int
    {
        $this->prepareNodeVisitors();
        return \count($this->visitors);
    }
    public function hasZeroCacheRectors() : bool
    {
        $this->prepareNodeVisitors();
        return (bool) $this->getZeroCacheRectorCount();
    }
    public function getZeroCacheRectorCount() : int
    {
        $this->prepareNodeVisitors();
        $zeroCacheRectors = \array_filter($this->allPhpRectors, function (\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool {
            return $phpRector instanceof \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
        });
        return \count($zeroCacheRectors);
    }
    /**
     * Mostly used for testing
     */
    private function activateEnabledRectorOnly() : void
    {
        $this->visitors = [];
        $enabledRectorClass = $this->enabledRectorClassProvider->getEnabledRectorClass();
        foreach ($this->allPhpRectors as $allPhpRector) {
            if (!\is_a($allPhpRector, $enabledRectorClass, \true)) {
                continue;
            }
            $this->addVisitor($allPhpRector);
            break;
        }
    }
    private function hasFileNodeRectorsEnabled() : bool
    {
        foreach ($this->visitors as $visitor) {
            if (!$visitor instanceof \Rector\Core\Contract\Rector\PhpRectorInterface) {
                continue;
            }
            if (\in_array(\Rector\Core\PhpParser\Node\CustomNode\FileNode::class, $visitor->getNodeTypes(), \true)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * This must happen after $this->configuration is set after ProcessCommand::execute() is run,
     * otherwise we get default false positives.
     *
     * This hack should be removed after https://github.com/rectorphp/rector/issues/5584 is resolved
     */
    private function prepareNodeVisitors() : void
    {
        if ($this->areNodeVisitorsPrepared) {
            return;
        }
        foreach ($this->allPhpRectors as $allPhpRector) {
            if ($this->configuration->isCacheEnabled() && !$this->configuration->shouldClearCache() && $allPhpRector instanceof \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface) {
                continue;
            }
            $this->addVisitor($allPhpRector);
        }
        $this->areNodeVisitorsPrepared = \true;
    }
}
