<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class ReturnTypeDeclarationReturnTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var FunctionLikeReturnTypeResolver
     */
    private $functionLikeReturnTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver)
    {
        $this->functionLikeReturnTypeResolver = $functionLikeReturnTypeResolver;
    }
    public function inferFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($functionLike->getReturnType() === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        // resolve later with more precise type, e.g. Type[]
        if ($this->nodeNameResolver->isNames($functionLike->getReturnType(), ['array', 'iterable'])) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($functionLike);
    }
    public function getPriority() : int
    {
        return 2000;
    }
}
