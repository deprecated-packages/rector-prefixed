<?php

declare (strict_types=1);
namespace RectorPrefix20210504\Example\Tests;

use RectorPrefix20210504\Example\ClassA;
use RectorPrefix20210504\Example\ClassAHelperTrait;
class ClassATestWithUse
{
    public function test() : void
    {
        $anonStub = new class extends \RectorPrefix20210504\Example\ClassA
        {
            use ClassAHelperTrait;
        };
    }
}
