<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithAssert extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    public function doAssertThis()
    {
        $this->anotherMethod();
    }
    private function anotherMethod()
    {
        $this->assertTrue(\true);
    }
}
