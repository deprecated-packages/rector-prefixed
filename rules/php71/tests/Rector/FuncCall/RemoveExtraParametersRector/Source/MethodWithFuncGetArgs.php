<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\Source;

final class MethodWithFuncGetArgs
{
    public static function call($me)
    {
        $us = \func_get_args();
    }
    public static function betterCall($me)
    {
        $us = better_func_get_args();
    }
}
function better_func_get_args()
{
    return 5;
}
