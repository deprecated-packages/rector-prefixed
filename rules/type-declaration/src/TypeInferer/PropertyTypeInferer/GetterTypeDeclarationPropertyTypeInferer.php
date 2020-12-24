<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\NodeAnalyzer\ClassMethodAndPropertyAnalyzer;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class GetterTypeDeclarationPropertyTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var FunctionLikeReturnTypeResolver
     */
    private $functionLikeReturnTypeResolver;
    /**
     * @var ClassMethodAndPropertyAnalyzer
     */
    private $classMethodAndPropertyAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver, \_PhpScopere8e811afab72\Rector\TypeDeclaration\NodeAnalyzer\ClassMethodAndPropertyAnalyzer $classMethodAndPropertyAnalyzer)
    {
        $this->functionLikeReturnTypeResolver = $functionLikeReturnTypeResolver;
        $this->classMethodAndPropertyAnalyzer = $classMethodAndPropertyAnalyzer;
    }
    public function inferProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        foreach ($classLike->getMethods() as $classMethod) {
            if (!$this->classMethodAndPropertyAnalyzer->hasClassMethodOnlyStatementReturnOfPropertyFetch($classMethod, $propertyName)) {
                continue;
            }
            $returnType = $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($classMethod);
            // let PhpDoc solve that later for more precise type
            if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
            }
            if (!$returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                return $returnType;
            }
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 630;
    }
}
