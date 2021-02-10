<?php

declare (strict_types=1);
namespace Rector\PostRector\Application;

use PhpParser\Node;
use PhpParser\NodeTraverser;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\PostRector\Contract\Rector\PostRectorInterface;
use RectorPrefix20210210\Symplify\Skipper\Skipper\Skipper;
use RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo;
final class PostFileProcessor
{
    /**
     * @var PostRectorInterface[]
     */
    private $postRectors = [];
    /**
     * @var Skipper
     */
    private $skipper;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    /**
     * @param PostRectorInterface[] $postRectors
     */
    public function __construct(\RectorPrefix20210210\Symplify\Skipper\Skipper\Skipper $skipper, \Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider, array $postRectors)
    {
        $this->postRectors = $this->sortByPriority($postRectors);
        $this->skipper = $skipper;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function traverse(array $nodes) : array
    {
        foreach ($this->postRectors as $postRector) {
            if ($this->shouldSkipPostRector($postRector)) {
                continue;
            }
            $nodeTraverser = new \PhpParser\NodeTraverser();
            $nodeTraverser->addVisitor($postRector);
            $nodes = $nodeTraverser->traverse($nodes);
        }
        return $nodes;
    }
    /**
     * @param PostRectorInterface[] $postRectors
     * @return PostRectorInterface[]
     */
    private function sortByPriority(array $postRectors) : array
    {
        $postRectorsByPriority = [];
        foreach ($postRectors as $postRector) {
            if (isset($postRectorsByPriority[$postRector->getPriority()])) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $postRectorsByPriority[$postRector->getPriority()] = $postRector;
        }
        \krsort($postRectorsByPriority);
        return $postRectorsByPriority;
    }
    private function shouldSkipPostRector(\Rector\PostRector\Contract\Rector\PostRectorInterface $postRector) : bool
    {
        $smartFileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
        if (!$smartFileInfo instanceof \RectorPrefix20210210\Symplify\SmartFileSystem\SmartFileInfo) {
            return \false;
        }
        return $this->skipper->shouldSkipElementAndFileInfo($postRector, $smartFileInfo);
    }
}
