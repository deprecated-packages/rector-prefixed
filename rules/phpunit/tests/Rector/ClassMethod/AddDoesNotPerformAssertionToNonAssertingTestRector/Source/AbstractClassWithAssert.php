<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use _PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithAssert extends \_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase
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
