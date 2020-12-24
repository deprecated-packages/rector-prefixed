<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithStaticAssert extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
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
