<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use RectorPrefix20210303\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithAssert extends \RectorPrefix20210303\PHPUnit\Framework\TestCase
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
