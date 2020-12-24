<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PostRector\Application;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\PostRector\Contract\Rector\PostRectorInterface;
final class PostFileProcessor
{
    /**
     * @var PostRectorInterface[]
     */
    private $postRectors = [];
    /**
     * @param PostRectorInterface[] $postRectors
     */
    public function __construct(array $postRectors)
    {
        $this->postRectors = $this->sortByPriority($postRectors);
    }
    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function traverse(array $nodes) : array
    {
        foreach ($this->postRectors as $postRector) {
            $nodeTraverser = new \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser();
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
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            $postRectorsByPriority[$postRector->getPriority()] = $postRector;
        }
        \krsort($postRectorsByPriority);
        return $postRectorsByPriority;
    }
}
