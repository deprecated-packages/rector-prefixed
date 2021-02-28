<?php

declare (strict_types=1);
namespace Rector\Php70\Tests\Rector\FuncCall\NonVariableToVariableOnFunctionCallRector\Source;

final class VariousCallsClass
{
    public static function staticMethod(&$bar)
    {
    }
    public function baz(&$bar)
    {
    }
    public function child() : \Rector\Php70\Tests\Rector\FuncCall\NonVariableToVariableOnFunctionCallRector\Source\ChildClass
    {
        return new \Rector\Php70\Tests\Rector\FuncCall\NonVariableToVariableOnFunctionCallRector\Source\ChildClass();
    }
}
