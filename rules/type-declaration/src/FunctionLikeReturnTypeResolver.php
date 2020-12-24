<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration;

use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
final class FunctionLikeReturnTypeResolver
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function resolveFunctionLikeReturnTypeToPHPStanType(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $functionReturnType = $functionLike->getReturnType();
        if ($functionReturnType === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionReturnType);
    }
}
