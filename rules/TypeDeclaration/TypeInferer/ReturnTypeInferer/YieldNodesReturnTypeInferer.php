<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Expr\YieldFrom;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\NodeTraverser;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedGenericObjectType;
use Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType;
use Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class YieldNodesReturnTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeFactory = $typeFactory;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function inferFunctionLike(\PhpParser\Node\FunctionLike $functionLike) : \PHPStan\Type\Type
    {
        $yieldNodes = $this->findCurrentScopeYieldNodes($functionLike);
        if ($yieldNodes === []) {
            return new \PHPStan\Type\MixedType();
        }
        $types = [];
        foreach ($yieldNodes as $yieldNode) {
            $value = $this->resolveYieldValue($yieldNode);
            if (!$value instanceof \PhpParser\Node\Expr) {
                continue;
            }
            $resolvedType = $this->nodeTypeResolver->getStaticType($value);
            if ($resolvedType instanceof \PHPStan\Type\MixedType) {
                continue;
            }
            $types[] = $resolvedType;
        }
        if ($types === []) {
            return new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedObjectType('Iterator');
        }
        $types = $this->typeFactory->createMixedPassedOrUnionType($types);
        return new \Rector\StaticTypeMapper\ValueObject\Type\FullyQualifiedGenericObjectType('Iterator', [$types]);
    }
    public function getPriority() : int
    {
        return 1200;
    }
    /**
     * @return Yield_[]|YieldFrom[]
     */
    private function findCurrentScopeYieldNodes(\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $yieldNodes = [];
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $functionLike->getStmts(), function (\PhpParser\Node $node) use(&$yieldNodes) : ?int {
            // skip nested scope
            if ($node instanceof \PhpParser\Node\FunctionLike) {
                return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \PhpParser\Node\Expr\Yield_ && !$node instanceof \PhpParser\Node\Expr\YieldFrom) {
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
    private function resolveYieldValue(\PhpParser\Node\Expr $yieldExpr) : ?\PhpParser\Node\Expr
    {
        if ($yieldExpr instanceof \PhpParser\Node\Expr\Yield_) {
            return $yieldExpr->value;
        }
        return $yieldExpr->expr;
    }
}
