<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class ReturnTypeDeclarationReturnTypeInferer extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var FunctionLikeReturnTypeResolver
     */
    private $functionLikeReturnTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\FunctionLikeReturnTypeResolver $functionLikeReturnTypeResolver)
    {
        $this->functionLikeReturnTypeResolver = $functionLikeReturnTypeResolver;
    }
    public function inferFunctionLike(\_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($functionLike->getReturnType() === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        // resolve later with more precise type, e.g. Type[]
        if ($this->nodeNameResolver->isNames($functionLike->getReturnType(), ['array', 'iterable'])) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $this->functionLikeReturnTypeResolver->resolveFunctionLikeReturnTypeToPHPStanType($functionLike);
    }
    public function getPriority() : int
    {
        return 2000;
    }
}
