<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\NodeAnalyzer\ClassMethodAndPropertyAnalyzer;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnedNodesReturnTypeInferer;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTagReturnTypeInferer;
final class GetterPropertyTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
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
    /**
     * @var ClassMethodAndPropertyAnalyzer
     */
    private $classMethodAndPropertyAnalyzer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnTagReturnTypeInferer $returnTagReturnTypeInferer, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer\ReturnedNodesReturnTypeInferer $returnedNodesReturnTypeInferer, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver, \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\NodeAnalyzer\ClassMethodAndPropertyAnalyzer $classMethodAndPropertyAnalyzer)
    {
        $this->returnedNodesReturnTypeInferer = $returnedNodesReturnTypeInferer;
        $this->returnTagReturnTypeInferer = $returnTagReturnTypeInferer;
        $this->functionLikeReturnTypeResolver = $functionLikeReturnTypeResolver;
        $this->classMethodAndPropertyAnalyzer = $classMethodAndPropertyAnalyzer;
    }
    public function inferProperty(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        foreach ($classLike->getMethods() as $classMethod) {
            if (!$this->classMethodAndPropertyAnalyzer->hasClassMethodOnlyStatementReturnOfPropertyFetch($classMethod, $propertyName)) {
                continue;
            }
            $returnType = $this->inferClassMethodReturnType($classMethod);
            if (!$returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                return $returnType;
            }
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 1700;
    }
    private function inferClassMethodReturnType(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $returnTypeDeclarationType = $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($classMethod);
        if (!$returnTypeDeclarationType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return $returnTypeDeclarationType;
        }
        $inferedType = $this->returnedNodesReturnTypeInferer->inferFunctionLike($classMethod);
        if (!$inferedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return $inferedType;
        }
        return $this->returnTagReturnTypeInferer->inferFunctionLike($classMethod);
    }
}
