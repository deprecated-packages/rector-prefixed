<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\Foo', 'Foo', \false);
