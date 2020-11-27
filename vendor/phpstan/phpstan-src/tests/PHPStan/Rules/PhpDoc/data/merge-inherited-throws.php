<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\InvalidThrowsPhpDocMergeInherited;

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
class Two extends \_PhpScoper006a73f0e455\InvalidThrowsPhpDocMergeInherited\One implements \_PhpScoper006a73f0e455\InvalidThrowsPhpDocMergeInherited\InterfaceOne
{
    /**
     * @throws C
     * @throws D
     */
    public function method() : void
    {
    }
}
class Three extends \_PhpScoper006a73f0e455\InvalidThrowsPhpDocMergeInherited\Two
{
    /** Some comment */
    public function method() : void
    {
    }
}
class Four extends \_PhpScoper006a73f0e455\InvalidThrowsPhpDocMergeInherited\Three
{
    public function method() : void
    {
    }
}
