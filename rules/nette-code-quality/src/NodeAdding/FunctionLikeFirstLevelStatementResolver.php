<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteCodeQuality\NodeAdding;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\NodeNestingScope\ParentScopeFinder;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
final class FunctionLikeFirstLevelStatementResolver
{
    /**
     * @var ParentScopeFinder
     */
    private $parentScopeFinder;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeNestingScope\ParentScopeFinder $parentScopeFinder)
    {
        $this->parentScopeFinder = $parentScopeFinder;
    }
    public function resolveFirstLevelStatement(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $multiplierClosure = $this->matchMultiplierClosure($node);
        $functionLike = $multiplierClosure ?? $this->parentScopeFinder->find($node);
        /** @var ClassMethod|Closure|null $functionLike */
        if ($functionLike === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $currentStatement = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        if (!$currentStatement instanceof \_PhpScoper0a6b37af0871\PhpParser\Node) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        while (!\in_array($currentStatement, (array) $functionLike->stmts, \true)) {
            $parent = $currentStatement->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if (!$parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            $currentStatement = $parent->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        }
        return $currentStatement;
    }
    /**
     * Form might be costructured inside private closure for multiplier
     * @see https://doc.nette.org/en/3.0/multiplier
     */
    private function matchMultiplierClosure(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure
    {
        /** @var Closure|null $closure */
        $closure = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLOSURE_NODE);
        if ($closure === null) {
            return null;
        }
        $parent = $closure->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Arg) {
            return null;
        }
        $parentParent = $parent->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentParent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return null;
        }
        return $closure;
    }
}
