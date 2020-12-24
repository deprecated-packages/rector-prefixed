<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class TrivialParametersAcceptor implements \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor
{
    public function getTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array
    {
        return [];
    }
    public function isVariadic() : bool
    {
        return \true;
    }
    public function getReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
