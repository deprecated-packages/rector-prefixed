<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\YieldFrom;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class YieldNodesReturnTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function inferFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $yieldNodes = $this->findCurrentScopeYieldNodes($functionLike);
        if ($yieldNodes === []) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $types = [];
        foreach ($yieldNodes as $yieldNode) {
            $value = $this->resolveYieldValue($yieldNode);
            if ($value === null) {
                continue;
            }
            $yieldValueStaticType = $this->nodeTypeResolver->getStaticType($value);
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $yieldValueStaticType);
        }
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScopere8e811afab72\Rector\Core\ValueObject\PhpVersionFeature::ITERABLE_TYPE)) {
            // @see https://www.php.net/manual/en/language.types.iterable.php
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\IterableType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        } else {
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\Iterator::class);
        }
        return $this->typeFactory->createMixedPassedOrUnionType($types);
    }
    public function getPriority() : int
    {
        return 1200;
    }
    /**
     * @return Yield_[]|YieldFrom[]
     */
    private function findCurrentScopeYieldNodes(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $yieldNodes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $functionLike->getStmts(), function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$yieldNodes) : ?int {
            // skip nested scope
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike) {
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_ && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\YieldFrom) {
                return null;
            }
            $yieldNodes[] = $node;
            return null;
        });
        return $yieldNodes;
    }
    /**
     * @param Yield_|YieldFrom $yieldExpr
     */
    private function resolveYieldValue(\_PhpScopere8e811afab72\PhpParser\Node\Expr $yieldExpr) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($yieldExpr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_) {
            return $yieldExpr->value;
        }
        return $yieldExpr->expr;
    }
}
