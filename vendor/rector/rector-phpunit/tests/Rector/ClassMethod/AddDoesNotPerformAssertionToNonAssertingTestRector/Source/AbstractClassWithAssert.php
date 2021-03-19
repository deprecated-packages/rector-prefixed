<?php

declare (strict_types=1);
namespace Rector\Tests\PHPUnit\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use RectorPrefix20210319\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithAssert extends \RectorPrefix20210319\PHPUnit\Framework\TestCase
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
