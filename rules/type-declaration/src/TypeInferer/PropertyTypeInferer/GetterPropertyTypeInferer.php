<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnedNodesReturnTypeInferer;
use Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTagReturnTypeInferer;
final class GetterPropertyTypeInferer extends \Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var ReturnedNodesReturnTypeInferer
     */
    private $returnedNodesReturnTypeInferer;
    /**
     * @var ReturnTagReturnTypeInferer
     */
    private $returnTagReturnTypeInferer;
    /**
     * @var FunctionLikeReturnTypeResolver
     */
    private $functionLikeReturnTypeResolver;
    public function __construct(\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTagReturnTypeInferer $returnTagReturnTypeInferer, \Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnedNodesReturnTypeInferer $returnedNodesReturnTypeInferer, \Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver)
    {
        $this->returnedNodesReturnTypeInferer = $returnedNodesReturnTypeInferer;
        $this->returnTagReturnTypeInferer = $returnTagReturnTypeInferer;
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
            $returnType = $this->inferClassMethodReturnType($classMethod);
            if (!$returnType instanceof \PHPStan\Type\MixedType) {
                return $returnType;
            }
        }
        return new \PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 1700;
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
    private function inferClassMethodReturnType(\PhpParser\Node\Stmt\ClassMethod $classMethod) : \PHPStan\Type\Type
    {
        $returnTypeDeclarationType = $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($classMethod);
        if (!$returnTypeDeclarationType instanceof \PHPStan\Type\MixedType) {
            return $returnTypeDeclarationType;
        }
        $inferedType = $this->returnedNodesReturnTypeInferer->inferFunctionLike($classMethod);
        if (!$inferedType instanceof \PHPStan\Type\MixedType) {
            return $inferedType;
        }
        return $this->returnTagReturnTypeInferer->inferFunctionLike($classMethod);
    }
}
