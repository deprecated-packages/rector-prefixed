<?php

declare (strict_types=1);
namespace Rector\PostRector\Collector;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Expression;
use Rector\ChangesReporting\Collector\AffectedFilesCollector;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeRemoval\BreakingRemovalGuard;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PostRector\Contract\Collector\NodeCollectorInterface;
use RectorPrefix20201231\Symplify\SmartFileSystem\SmartFileInfo;
final class NodesToRemoveCollector implements \Rector\PostRector\Contract\Collector\NodeCollectorInterface
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
    public function __construct(\Rector\ChangesReporting\Collector\AffectedFilesCollector $affectedFilesCollector, \Rector\NodeRemoval\BreakingRemovalGuard $breakingRemovalGuard)
    {
        $this->affectedFilesCollector = $affectedFilesCollector;
        $this->breakingRemovalGuard = $breakingRemovalGuard;
    }
    public function addNodeToRemove(\PhpParser\Node $node) : void
    {
        // chain call: "->method()->another()"
        $this->ensureIsNotPartOfChainMethodCall($node);
        $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \PhpParser\Node\Stmt\Expression && $parentNode instanceof \PhpParser\Node\Stmt\Expression) {
            // only expressions can be removed
            $node = $parentNode;
        } else {
            $this->breakingRemovalGuard->ensureNodeCanBeRemove($node);
        }
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo !== null) {
            $this->affectedFilesCollector->addFile($fileInfo);
        }
        /** @var Stmt $node */
        $this->nodesToRemove[] = $node;
    }
    public function isNodeRemoved(\PhpParser\Node $node) : bool
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
    private function ensureIsNotPartOfChainMethodCall(\PhpParser\Node $node) : void
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return;
        }
        if (!$node->var instanceof \PhpParser\Node\Expr\MethodCall) {
            return;
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException('Chain method calls cannot be removed this way. It would remove the whole tree of calls. Remove them manually by creating new parent node with no following method.');
    }
}
