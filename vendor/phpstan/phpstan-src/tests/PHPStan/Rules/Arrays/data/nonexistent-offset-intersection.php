<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\Foo', 'Foo', \false);
