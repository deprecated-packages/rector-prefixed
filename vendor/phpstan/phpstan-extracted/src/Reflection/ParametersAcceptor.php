<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface ParametersAcceptor
{
    public const VARIADIC_FUNCTIONS = ['func_get_args', 'func_get_arg', 'func_num_args'];
    public function getTemplateTypeMap() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
    public function getResolvedTemplateTypeMap() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array;
    public function isVariadic() : bool;
    public function getReturnType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
