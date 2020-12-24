<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\PropertyTypeInferer;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\NodeAnalyzer\ClassMethodAndPropertyAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class GetterTypeDeclarationPropertyTypeInferer extends \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Contract\TypeInferer\PropertyTypeInfererInterface
{
    /**
     * @var FunctionLikeReturnTypeResolver
     */
    private $functionLikeReturnTypeResolver;
    /**
     * @var ClassMethodAndPropertyAnalyzer
     */
    private $classMethodAndPropertyAnalyzer;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver, \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\NodeAnalyzer\ClassMethodAndPropertyAnalyzer $classMethodAndPropertyAnalyzer)
    {
        $this->functionLikeReturnTypeResolver = $functionLikeReturnTypeResolver;
        $this->classMethodAndPropertyAnalyzer = $classMethodAndPropertyAnalyzer;
    }
    public function inferProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        /** @var Class_|null $classLike */
        $classLike = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            // anonymous class
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        /** @var string $propertyName */
        $propertyName = $this->nodeNameResolver->getName($property);
        foreach ($classLike->getMethods() as $classMethod) {
            if (!$this->classMethodAndPropertyAnalyzer->hasClassMethodOnlyStatementReturnOfPropertyFetch($classMethod, $propertyName)) {
                continue;
            }
            $returnType = $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($classMethod);
            // let PhpDoc solve that later for more precise type
            if ($returnType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
            }
            if (!$returnType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                return $returnType;
            }
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
    public function getPriority() : int
    {
        return 630;
    }
}
