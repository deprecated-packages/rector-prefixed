<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\InvalidThrowsPhpDocMergeInherited;

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
class Two extends \_PhpScoperabd03f0baf05\InvalidThrowsPhpDocMergeInherited\One implements \_PhpScoperabd03f0baf05\InvalidThrowsPhpDocMergeInherited\InterfaceOne
{
    /**
     * @throws C
     * @throws D
     */
    public function method() : void
    {
    }
}
class Three extends \_PhpScoperabd03f0baf05\InvalidThrowsPhpDocMergeInherited\Two
{
    /** Some comment */
    public function method() : void
    {
    }
}
class Four extends \_PhpScoperabd03f0baf05\InvalidThrowsPhpDocMergeInherited\Three
{
    public function method() : void
    {
    }
}
