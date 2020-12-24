<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source;

final class ClassWithStaticMethods
{
    public static function create($value)
    {
        return $value;
    }
}
