<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source;

final class ClassWithStaticMethods
{
    public static function create($value)
    {
        return $value;
    }
}
