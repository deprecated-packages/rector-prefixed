<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Yield_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\YieldFrom;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class YieldNodesReturnTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var PhpVersionProvider
     */
    private $phpVersionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Php\PhpVersionProvider $phpVersionProvider)
    {
        $this->phpVersionProvider = $phpVersionProvider;
    }
    /**
     * @param ClassMethod|Function_|Closure $functionLike
     */
    public function inferFunctionLike(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $yieldNodes = $this->findCurrentScopeYieldNodes($functionLike);
        if ($yieldNodes === []) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $types = [];
        foreach ($yieldNodes as $yieldNode) {
            $value = $this->resolveYieldValue($yieldNode);
            if ($value === null) {
                continue;
            }
            $yieldValueStaticType = $this->nodeTypeResolver->getStaticType($value);
            $types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $yieldValueStaticType);
        }
        if ($this->phpVersionProvider->isAtLeastPhpVersion(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::ITERABLE_TYPE)) {
            // @see https://www.php.net/manual/en/language.types.iterable.php
            $types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        } else {
            $types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\Iterator::class);
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
    private function findCurrentScopeYieldNodes(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $yieldNodes = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $functionLike->getStmts(), function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$yieldNodes) : ?int {
            // skip nested scope
            if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike) {
                return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Yield_ && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\YieldFrom) {
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
    private function resolveYieldValue(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $yieldExpr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($yieldExpr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Yield_) {
            return $yieldExpr->value;
        }
        return $yieldExpr->expr;
    }
}
