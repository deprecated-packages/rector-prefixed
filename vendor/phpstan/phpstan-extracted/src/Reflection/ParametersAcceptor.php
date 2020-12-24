<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface ParametersAcceptor
{
    public const VARIADIC_FUNCTIONS = ['func_get_args', 'func_get_arg', 'func_num_args'];
    public function getTemplateTypeMap() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
    public function getResolvedTemplateTypeMap() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array;
    public function isVariadic() : bool;
    public function getReturnType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
