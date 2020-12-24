<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeAdding;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class FunctionLikeFirstLevelStatementResolver
{
    /**
     * @var ParentScopeFinder
     */
    private $parentScopeFinder;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
    {
        $this->parentScopeFinder = $parentScopeFinder;
    }
    public function resolveFirstLevelStatement(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PhpParser\Node
    {
        $multiplierClosure = $this->matchMultiplierClosure($node);
        $functionLike = $multiplierClosure ?? $this->parentScopeFinder->find($node);
        /** @var ClassMethod|Closure|null $functionLike */
        if ($functionLike === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $currentStatement = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentStatement instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        while (!\in_array($currentStatement, (array) $functionLike->stmts, \true)) {
            $parent = $currentStatement->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parent instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            $currentStatement = $parent->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        }
        return $currentStatement;
    }
    /**
     * Form might be costructured inside private closure for multiplier
     * @see https://doc.nette.org/en/3.0/multiplier
     */
    private function matchMultiplierClosure(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure
    {
        /** @var Closure|null $closure */
        $closure = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE);
        if ($closure === null) {
            return null;
        }
        $parent = $closure->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Arg) {
            return null;
        }
        $parentParent = $parent->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return null;
        }
        return $closure;
    }
}
