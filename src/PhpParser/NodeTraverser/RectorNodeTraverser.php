<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\NodeFinder;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScopere8e811afab72\Rector\Core\Configuration\Configuration;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Testing\Application\EnabledRectorsProvider;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class RectorNodeTraverser extends \_PhpScopere8e811afab72\PhpParser\NodeTraverser
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Testing\Application\EnabledRectorsProvider $enabledRectorsProvider, \_PhpScopere8e811afab72\Rector\Core\Configuration\Configuration $configuration, \_PhpScopere8e811afab72\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider, \_PhpScopere8e811afab72\PhpParser\NodeFinder $nodeFinder, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        /** @var PhpRectorInterface[] $phpRectors */
        $phpRectors = $activeRectorsProvider->provideByType(\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface::class);
        $this->allPhpRectors = $phpRectors;
        $this->enabledRectorsProvider = $enabledRectorsProvider;
        foreach ($phpRectors as $phpRector) {
            if ($configuration->isCacheEnabled() && !$configuration->shouldClearCache() && $phpRector instanceof \_PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface) {
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
    public function traverseFileNode(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode) : array
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
        $hasNamespace = (bool) $this->nodeFinder->findFirstInstanceOf($nodes, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_::class);
        if (!$hasNamespace && $nodes !== []) {
            $fileWithoutNamespace = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace($nodes);
            $fileWithoutNamespace->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $this->currentFileInfoProvider->getSmartFileInfo());
            $firstNode = $nodes[0];
            $fileWithoutNamespace->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::DECLARES, $firstNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::DECLARES));
            return parent::traverse([$fileWithoutNamespace]);
        }
        return parent::traverse($nodes);
    }
    public function getPhpRectorCount() : int
    {
        return \count((array) $this->visitors);
    }
    public function hasZeroCacheRectors() : bool
    {
        return (bool) $this->getZeroCacheRectorCount();
    }
    public function getZeroCacheRectorCount() : int
    {
        $zeroCacheRectors = \array_filter($this->allPhpRectors, function (\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool {
            return $phpRector instanceof \_PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
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
            if (!$visitor instanceof \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface) {
                continue;
            }
            if (!\in_array(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\CustomNode\FileNode::class, $visitor->getNodeTypes(), \true)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param mixed[] $configuration
     */
    private function configureTestedRector(\_PhpScopere8e811afab72\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, array $configuration) : void
    {
        if (!\_PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            if ($phpRector instanceof \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface && $configuration === []) {
                $message = \sprintf('Rule "%s" is running without any configuration, is that on purpose?', \get_class($phpRector));
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            return;
        }
        if ($phpRector instanceof \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface) {
            $phpRector->configure($configuration);
        } elseif ($configuration !== []) {
            $message = \sprintf('Rule "%s" with configuration must implement "%s"', \get_class($phpRector), \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface::class);
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException($message);
        }
    }
}
