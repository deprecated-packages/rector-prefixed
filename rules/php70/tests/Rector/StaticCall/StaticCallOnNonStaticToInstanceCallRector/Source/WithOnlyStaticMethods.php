<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php70\Tests\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector\Source;

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
