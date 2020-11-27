<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

class Foo
{
    /** @var \ArrayAccess<string, mixed> */
    private $fooA;
    /** @var \ArrayAccess<string, mixed>&iterable<mixed> */
    private $fooB;
    /** @var \ArrayAccess<string, mixed>&\Countable */
    private $fooC;
    /** @var \ArrayAccess<string, mixed>&\stdClass */
    private $fooD;
    public function test() : void
    {
        $a = $this->fooA['bar'];
        $b = $this->fooB['bar'];
        $c = $this->fooC['bar'];
        $d = $this->fooD['bar'];
    }
}
\class_alias('_PhpScopera143bcca66cb\\Foo', 'Foo', \false);
