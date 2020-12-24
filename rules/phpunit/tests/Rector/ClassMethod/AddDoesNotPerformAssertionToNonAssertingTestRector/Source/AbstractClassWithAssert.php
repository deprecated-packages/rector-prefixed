<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
abstract class AbstractClassWithAssert extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
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
