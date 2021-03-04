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
use PHPStan\Type\ArrayType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\Core\Php\PhpVersionProvider;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use RectorPrefix20210304\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class YieldNodesReturnTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
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
    public function __construct(\Rector\Core\Php\PhpVersionProvider $phpVersionProvider, \Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory, \RectorPrefix20210304\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->phpVersionProvider = $phpVersionProvider;
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
            $yieldValueStaticType = $this->nodeTypeResolver->getStaticType($value);
            $types[] = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $yieldValueStaticType);
        }
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::ITERABLE_TYPE)) {
            // @see https://www.php.net/manual/en/language.types.iterable.php
            $types[] = new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        } else {
            $types[] = new \PHPStan\Type\ObjectType('Iterator');
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
