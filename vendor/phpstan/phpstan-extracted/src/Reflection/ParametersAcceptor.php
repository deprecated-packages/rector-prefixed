<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface ParametersAcceptor
{
    public const VARIADIC_FUNCTIONS = ['func_get_args', 'func_get_arg', 'func_num_args'];
    public function getTemplateTypeMap() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
    public function getResolvedTemplateTypeMap() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array;
    public function isVariadic() : bool;
    public function getReturnType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
