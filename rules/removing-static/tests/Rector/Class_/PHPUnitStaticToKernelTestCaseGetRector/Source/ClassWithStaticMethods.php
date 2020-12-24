<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source;

final class ClassWithStaticMethods
{
    public static function create($value)
    {
        return $value;
    }
}
