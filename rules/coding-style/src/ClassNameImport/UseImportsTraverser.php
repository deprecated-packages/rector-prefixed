<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\ClassNameImport;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\GroupUse;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class UseImportsTraverser
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var CallableNodeTraverser
     */
    private $callableNodeTraverser;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\NodeTraverser\CallableNodeTraverser $callableNodeTraverser, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->callableNodeTraverser = $callableNodeTraverser;
    }
    /**
     * @param Stmt[] $stmts
     */
    public function traverserStmtsForFunctions(array $stmts, callable $callable) : void
    {
        $this->traverseForType($stmts, $callable, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
    }
    /**
     * @param Stmt[] $stmts
     */
    public function traverserStmts(array $stmts, callable $callable) : void
    {
        $this->traverseForType($stmts, $callable, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_NORMAL);
    }
    /**
     * @param Stmt[] $stmts
     */
    private function traverseForType(array $stmts, callable $callable, int $desiredType) : void
    {
        $this->callableNodeTraverser->traverseNodesWithCallable($stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($callable, $desiredType) {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_) {
                // only import uses
                if ($node->type !== $desiredType) {
                    return null;
                }
                foreach ($node->uses as $useUse) {
                    $name = $this->nodeNameResolver->getName($useUse);
                    $callable($useUse, $name);
                }
            }
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\GroupUse) {
                $this->processGroupUse($node, $desiredType, $callable);
            }
            return null;
        });
    }
    private function processGroupUse(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\GroupUse $groupUse, int $desiredType, callable $callable) : void
    {
        if ($groupUse->type !== \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN) {
            return;
        }
        $prefixName = $groupUse->prefix->toString();
        foreach ($groupUse->uses as $useUse) {
            if ($useUse->type !== $desiredType) {
                continue;
            }
            $name = $prefixName . '\\' . $this->nodeNameResolver->getName($useUse);
            $callable($useUse, $name);
        }
    }
}
