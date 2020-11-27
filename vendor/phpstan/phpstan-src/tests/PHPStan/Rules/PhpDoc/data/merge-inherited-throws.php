<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\InvalidThrowsPhpDocMergeInherited;

class A
{
}
class B
{
}
class C
{
}
class D
{
}
class One
{
    /** @throws A */
    public function method() : void
    {
    }
}
interface InterfaceOne
{
    /** @throws B */
    public function method() : void;
}
class Two extends \_PhpScoper26e51eeacccf\InvalidThrowsPhpDocMergeInherited\One implements \_PhpScoper26e51eeacccf\InvalidThrowsPhpDocMergeInherited\InterfaceOne
{
    /**
     * @throws C
     * @throws D
     */
    public function method() : void
    {
    }
}
class Three extends \_PhpScoper26e51eeacccf\InvalidThrowsPhpDocMergeInherited\Two
{
    /** Some comment */
    public function method() : void
    {
    }
}
class Four extends \_PhpScoper26e51eeacccf\InvalidThrowsPhpDocMergeInherited\Three
{
    public function method() : void
    {
    }
}
