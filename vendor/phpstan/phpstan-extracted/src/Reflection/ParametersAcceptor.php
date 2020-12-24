<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface ParametersAcceptor
{
    public const VARIADIC_FUNCTIONS = ['func_get_args', 'func_get_arg', 'func_num_args'];
    public function getTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
    public function getResolvedTemplateTypeMap() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array;
    public function isVariadic() : bool;
    public function getReturnType() : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
