<?php

declare (strict_types=1);
namespace RectorPrefix20210504\Example\Tests;

class ClassATest
{
    public function test() : void
    {
        $anonStub = new class extends \RectorPrefix20210504\Example\ClassA
        {
            use \Example\ClassAHelperTrait;
        };
    }
}
