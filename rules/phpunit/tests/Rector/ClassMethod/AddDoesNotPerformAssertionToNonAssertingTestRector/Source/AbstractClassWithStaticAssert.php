<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithStaticAssert extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    public function doAssertThis()
    {
        self::anotherMethod();
    }
    private static function anotherMethod()
    {
        self::assertTrue(\true);
    }
}
