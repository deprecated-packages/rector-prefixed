<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
final class FunctionLikeReturnTypeResolver
{
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    public function __construct(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper)
    {
        $this->staticTypeMapper = $staticTypeMapper;
    }
    public function resolveFunctionLikeReturnTypeToPHPStanType(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $functionReturnType = $functionLike->getReturnType();
        if ($functionReturnType === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $this->staticTypeMapper->mapPhpParserNodePHPStanType($functionReturnType);
    }
}
