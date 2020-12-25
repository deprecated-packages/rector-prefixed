<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use _PhpScoper267b3276efc2\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithAssert extends \_PhpScoper267b3276efc2\PHPUnit\Framework\TestCase
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
