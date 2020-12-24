<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use _PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithStaticAssert extends \_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase
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
