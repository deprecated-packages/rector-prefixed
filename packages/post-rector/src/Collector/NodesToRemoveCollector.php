<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Collector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\Collector\AffectedFilesCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval\BreakingRemovalGuard;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class NodesToRemoveCollector implements \_PhpScoper2a4e7ab1ecbc\Rector\PostRector\Contract\Collector\NodeCollectorInterface
{
    /**
     * @var AffectedFilesCollector
     */
    private $affectedFilesCollector;
    /**
     * @var BreakingRemovalGuard
     */
    private $breakingRemovalGuard;
    /**
     * @var Stmt[]|Node[]
     */
    private $nodesToRemove = [];
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\ChangesReporting\Collector\AffectedFilesCollector $affectedFilesCollector, \_PhpScoper2a4e7ab1ecbc\Rector\NodeRemoval\BreakingRemovalGuard $breakingRemovalGuard)
    {
        $this->affectedFilesCollector = $affectedFilesCollector;
        $this->breakingRemovalGuard = $breakingRemovalGuard;
    }
    public function addNodeToRemove(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        // chain call: "->method()->another()"
        $this->ensureIsNotPartOfChainMethodCall($node);
        $parentNode = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression && $parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
            // only expressions can be removed
            $node = $parentNode;
        } else {
            $this->breakingRemovalGuard->ensureNodeCanBeRemove($node);
        }
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo !== null) {
            $this->affectedFilesCollector->addFile($fileInfo);
        }
        /** @var Stmt $node */
        $this->nodesToRemove[] = $node;
    }
    public function isNodeRemoved(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : bool
    {
        return \in_array($node, $this->nodesToRemove, \true);
    }
    public function isActive() : bool
    {
        return $this->getCount() > 0;
    }
    public function getCount() : int
    {
        return \count($this->nodesToRemove);
    }
    /**
     * @return Node[]
     */
    public function getNodesToRemove() : array
    {
        return $this->nodesToRemove;
    }
    public function unset(int $key) : void
    {
        unset($this->nodesToRemove[$key]);
    }
    private function ensureIsNotPartOfChainMethodCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return;
        }
        if (!$node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return;
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException('Chain method calls cannot be removed this way. It would remove the whole tree of calls. Remove them manually by creating new parent node with no following method.');
    }
}
