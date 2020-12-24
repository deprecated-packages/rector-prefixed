<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PostRector\Collector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\AffectedFilesCollector;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\NodeRemoval\BreakingRemovalGuard;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PostRector\Contract\Collector\NodeCollectorInterface;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class NodesToRemoveCollector implements \_PhpScoperb75b35f52b74\Rector\PostRector\Contract\Collector\NodeCollectorInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\ChangesReporting\Collector\AffectedFilesCollector $affectedFilesCollector, \_PhpScoperb75b35f52b74\Rector\NodeRemoval\BreakingRemovalGuard $breakingRemovalGuard)
    {
        $this->affectedFilesCollector = $affectedFilesCollector;
        $this->breakingRemovalGuard = $breakingRemovalGuard;
    }
    public function addNodeToRemove(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        // chain call: "->method()->another()"
        $this->ensureIsNotPartOfChainMethodCall($node);
        $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression && $parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            // only expressions can be removed
            $node = $parentNode;
        } else {
            $this->breakingRemovalGuard->ensureNodeCanBeRemove($node);
        }
        /** @var SmartFileInfo|null $fileInfo */
        $fileInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        if ($fileInfo !== null) {
            $this->affectedFilesCollector->addFile($fileInfo);
        }
        /** @var Stmt $node */
        $this->nodesToRemove[] = $node;
    }
    public function isNodeRemoved(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : bool
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
    private function ensureIsNotPartOfChainMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return;
        }
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException('Chain method calls cannot be removed this way. It would remove the whole tree of calls. Remove them manually by creating new parent node with no following method.');
    }
}
