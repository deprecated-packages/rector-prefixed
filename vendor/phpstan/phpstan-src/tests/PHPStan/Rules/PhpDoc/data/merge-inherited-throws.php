<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\InvalidThrowsPhpDocMergeInherited;

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
class Two extends \_PhpScoperbd5d0c5f7638\InvalidThrowsPhpDocMergeInherited\One implements \_PhpScoperbd5d0c5f7638\InvalidThrowsPhpDocMergeInherited\InterfaceOne
{
    /**
     * @throws C
     * @throws D
     */
    public function method() : void
    {
    }
}
class Three extends \_PhpScoperbd5d0c5f7638\InvalidThrowsPhpDocMergeInherited\Two
{
    /** Some comment */
    public function method() : void
    {
    }
}
class Four extends \_PhpScoperbd5d0c5f7638\InvalidThrowsPhpDocMergeInherited\Three
{
    public function method() : void
    {
    }
}
