<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\InvalidThrowsPhpDocMergeInherited;

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
class Two extends \_PhpScopera143bcca66cb\InvalidThrowsPhpDocMergeInherited\One implements \_PhpScopera143bcca66cb\InvalidThrowsPhpDocMergeInherited\InterfaceOne
{
    /**
     * @throws C
     * @throws D
     */
    public function method() : void
    {
    }
}
class Three extends \_PhpScopera143bcca66cb\InvalidThrowsPhpDocMergeInherited\Two
{
    /** Some comment */
    public function method() : void
    {
    }
}
class Four extends \_PhpScopera143bcca66cb\InvalidThrowsPhpDocMergeInherited\Three
{
    public function method() : void
    {
    }
}
