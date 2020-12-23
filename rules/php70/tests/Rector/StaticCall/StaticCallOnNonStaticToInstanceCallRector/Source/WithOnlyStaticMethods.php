<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php70\Tests\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector\Source;

class WithOnlyStaticMethods
{
    public static function aBoolMethod() : bool
    {
        return \true;
    }
    public static function aStringMethod() : string
    {
        return 'yeah';
    }
}
