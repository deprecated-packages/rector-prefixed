<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class GetterTypeDeclarationPropertyTypeInferer extends \Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var FunctionLikeReturnTypeResolver
     */
    private $functionLikeReturnTypeResolver;
    public function __construct(\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver)
    {
        $this->functionLikeReturnTypeResolver = $functionLikeReturnTypeResolver;
    }
    public function inferProperty(\PhpParser\Node\Stmt\Property $property) : \PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \PHPStan\Type\MixedType();
        }
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        foreach ($classLike->getMethods() as $classMethod) {
            if (!$this->hasClassMethodOnlyStatementReturnOfPropertyFetch($classMethod, $propertyName)) {
                continue;
            }
            $returnType = $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($classMethod);
            // let PhpDoc solve that later for more precise type
            if ($returnType instanceof \PHPStan\Type\ArrayType) {
                return new \PHPStan\Type\MixedType();
            }
            if (!$returnType instanceof \PHPStan\Type\MixedType) {
                return $returnType;
            }
        }
        return new \PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 630;
    }
    private function hasClassMethodOnlyStatementReturnOfPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : bool
    {
        if (\count((array) $classMethod->stmts) !== 1) {
            return \false;
        }
        $onlyClassMethodStmt = $classMethod->stmts[0];
        if (!$onlyClassMethodStmt instanceof \PhpParser\Node\Stmt\Return_) {
            return \false;
        }
        /** @var Return_ $return */
        $return = $onlyClassMethodStmt;
        if (!$return->expr instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        return $this->nodeNameResolver->isName($return->expr, $propertyName);
    }
}
