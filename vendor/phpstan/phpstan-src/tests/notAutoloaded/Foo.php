<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\SomeOtherNamespace\Tests;

class Foo
{
    const FOO_CONST = 'foo';
    /** @var string */
    private $fooProperty;
    public function doFoo() : string
    {
        $this->fooProperty = 'test';
        return $this->fooProperty;
    }
}
