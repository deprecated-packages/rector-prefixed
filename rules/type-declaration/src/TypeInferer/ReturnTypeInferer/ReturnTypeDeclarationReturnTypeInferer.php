<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class ReturnTypeDeclarationReturnTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var FunctionLikeReturnTypeResolver
     */
    private $functionLikeReturnTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver)
    {
        $this->functionLikeReturnTypeResolver = $functionLikeReturnTypeResolver;
    }
    public function inferFunctionLike(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($functionLike->getReturnType() === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        // resolve later with more precise type, e.g. Type[]
        if ($this->nodeNameResolver->isNames($functionLike->getReturnType(), ['array', 'iterable'])) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($functionLike);
    }
    public function getPriority() : int
    {
        return 2000;
    }
}
