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
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Contract\Rector\PhpRectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Node\CustomNode\FileNode;
use Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Testing\Application\EnabledRectorsProvider;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class RectorNodeTraverser extends \PhpParser\NodeTraverser
{
    /**
     * @var PhpRectorInterface[]
     */
    private $allPhpRectors = [];
    /**
     * @var EnabledRectorsProvider
     */
    private $enabledRectorsProvider;
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    public function __construct(\Rector\Testing\Application\EnabledRectorsProvider $enabledRectorsProvider, \Rector\Core\Configuration\Configuration $configuration, \Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider, \PhpParser\NodeFinder $nodeFinder, \Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        /** @var PhpRectorInterface[] $phpRectors */
        $phpRectors = $activeRectorsProvider->provideByType(\Rector\Core\Contract\Rector\PhpRectorInterface::class);
        $this->allPhpRectors = $phpRectors;
        $this->enabledRectorsProvider = $enabledRectorsProvider;
        foreach ($phpRectors as $phpRector) {
            if ($configuration->isCacheEnabled() && !$configuration->shouldClearCache() && $phpRector instanceof \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface) {
                continue;
            }
            $this->addVisitor($phpRector);
        }
        $this->nodeFinder = $nodeFinder;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    /**
     * @return Node[]
     */
    public function traverseFileNode(\Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode) : array
    {
        if ($this->enabledRectorsProvider->isConfigured()) {
            $this->configureEnabledRectorsOnly();
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
        if ($this->enabledRectorsProvider->isConfigured()) {
            $this->configureEnabledRectorsOnly();
        }
        $hasNamespace = (bool) $this->nodeFinder->findFirstInstanceOf($nodes, \PhpParser\Node\Stmt\Namespace_::class);
        if (!$hasNamespace && $nodes !== []) {
            $fileWithoutNamespace = new \Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace($nodes);
            $fileWithoutNamespace->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $this->currentFileInfoProvider->getSmartFileInfo());
            $firstNode = $nodes[0];
            $fileWithoutNamespace->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::DECLARES, $firstNode->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::DECLARES));
            return parent::traverse([$fileWithoutNamespace]);
        }
        return parent::traverse($nodes);
    }
    public function getPhpRectorCount() : int
    {
        return \count($this->visitors);
    }
    public function hasZeroCacheRectors() : bool
    {
        return (bool) $this->getZeroCacheRectorCount();
    }
    public function getZeroCacheRectorCount() : int
    {
        $zeroCacheRectors = \array_filter($this->allPhpRectors, function (\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool {
            return $phpRector instanceof \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
        });
        return \count($zeroCacheRectors);
    }
    /**
     * Mostly used for testing
     */
    private function configureEnabledRectorsOnly() : void
    {
        $this->visitors = [];
        $enabledRectors = $this->enabledRectorsProvider->getEnabledRectors();
        foreach ($enabledRectors as $enabledRector => $configuration) {
            foreach ($this->allPhpRectors as $phpRector) {
                if (!\is_a($phpRector, $enabledRector, \true)) {
                    continue;
                }
                $this->configureTestedRector($phpRector, $configuration);
                $this->addVisitor($phpRector);
                continue 2;
            }
        }
    }
    private function hasFileNodeRectorsEnabled() : bool
    {
        foreach ($this->visitors as $visitor) {
            if (!$visitor instanceof \Rector\Core\Contract\Rector\PhpRectorInterface) {
                continue;
            }
            if (!\in_array(\Rector\Core\PhpParser\Node\CustomNode\FileNode::class, $visitor->getNodeTypes(), \true)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param mixed[] $configuration
     */
    private function configureTestedRector(\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, array $configuration) : void
    {
        if (!\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return;
        }
        if ($phpRector instanceof \Rector\Core\Contract\Rector\ConfigurableRectorInterface) {
            $phpRector->configure($configuration);
        } elseif ($configuration !== []) {
            $message = \sprintf('Rule "%s" with configuration must implement "%s"', \get_class($phpRector), \Rector\Core\Contract\Rector\ConfigurableRectorInterface::class);
            throw new \Rector\Core\Exception\ShouldNotHappenException($message);
        }
    }
}
