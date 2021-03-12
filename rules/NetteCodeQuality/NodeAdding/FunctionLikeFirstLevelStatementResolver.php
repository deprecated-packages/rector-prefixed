<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\NodeAdding;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\NodeNestingScope\ParentScopeFinder;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class FunctionLikeFirstLevelStatementResolver
{
    /**
     * @var ParentScopeFinder
     */
    private $parentScopeFinder;
    public function __construct(\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
    {
        $this->parentScopeFinder = $parentScopeFinder;
    }
    public function resolveFirstLevelStatement(\PhpParser\Node $node) : \PhpParser\Node
    {
        $multiplierClosure = $this->matchMultiplierClosure($node);
        /** @var ClassMethod|Closure|null $functionLike */
        $functionLike = $multiplierClosure ?? $this->parentScopeFinder->find($node);
        if ($functionLike === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $currentStatement = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentStatement instanceof \PhpParser\Node) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        while (!\in_array($currentStatement, (array) $functionLike->stmts, \true)) {
            $parent = $currentStatement->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parent instanceof \PhpParser\Node) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $currentStatement = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        }
        return $currentStatement;
    }
    /**
     * Form might be costructured inside private closure for multiplier
     * @see https://doc.nette.org/en/3.0/multiplier
     */
    private function matchMultiplierClosure(\PhpParser\Node $node) : ?\PhpParser\Node\Expr\Closure
    {
        $closure = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE);
        if (!$closure instanceof \PhpParser\Node\Expr\Closure) {
            return null;
        }
        $parent = $closure->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \PhpParser\Node\Arg) {
            return null;
        }
        $parentParent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParent instanceof \PhpParser\Node\Expr\New_) {
            return null;
        }
        return $closure;
    }
}
