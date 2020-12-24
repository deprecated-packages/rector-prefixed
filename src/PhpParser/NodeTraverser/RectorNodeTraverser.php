<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTraverser;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_;
use _PhpScoperb75b35f52b74\PhpParser\NodeFinder;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Application\ActiveRectorsProvider;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Testing\Application\EnabledRectorsProvider;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class RectorNodeTraverser extends \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Testing\Application\EnabledRectorsProvider $enabledRectorsProvider, \_PhpScoperb75b35f52b74\Rector\Core\Configuration\Configuration $configuration, \_PhpScoperb75b35f52b74\Rector\Core\Application\ActiveRectorsProvider $activeRectorsProvider, \_PhpScoperb75b35f52b74\PhpParser\NodeFinder $nodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider)
    {
        /** @var PhpRectorInterface[] $phpRectors */
        $phpRectors = $activeRectorsProvider->provideByType(\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface::class);
        $this->allPhpRectors = $phpRectors;
        $this->enabledRectorsProvider = $enabledRectorsProvider;
        foreach ($phpRectors as $phpRector) {
            if ($configuration->isCacheEnabled() && !$configuration->shouldClearCache() && $phpRector instanceof \_PhpScoperb75b35f52b74\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface) {
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
    public function traverseFileNode(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode $fileNode) : array
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
        $hasNamespace = (bool) $this->nodeFinder->findFirstInstanceOf($nodes, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Namespace_::class);
        if (!$hasNamespace && $nodes !== []) {
            $fileWithoutNamespace = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace($nodes);
            $fileWithoutNamespace->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO, $this->currentFileInfoProvider->getSmartFileInfo());
            $firstNode = $nodes[0];
            $fileWithoutNamespace->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::DECLARES, $firstNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::DECLARES));
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
        $zeroCacheRectors = \array_filter($this->allPhpRectors, function (\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector) : bool {
            return $phpRector instanceof \_PhpScoperb75b35f52b74\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
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
            if (!$visitor instanceof \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface) {
                continue;
            }
            if (!\in_array(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\CustomNode\FileNode::class, $visitor->getNodeTypes(), \true)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param mixed[] $configuration
     */
    private function configureTestedRector(\_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\PhpRectorInterface $phpRector, array $configuration) : void
    {
        if (!\_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            if ($phpRector instanceof \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface && $configuration === []) {
                $message = \sprintf('Rule "%s" is running without any configuration, is that on purpose?', \get_class($phpRector));
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException($message);
            }
            return;
        }
        if ($phpRector instanceof \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface) {
            $phpRector->configure($configuration);
        } elseif ($configuration !== []) {
            $message = \sprintf('Rule "%s" with configuration must implement "%s"', \get_class($phpRector), \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface::class);
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException($message);
        }
    }
}
