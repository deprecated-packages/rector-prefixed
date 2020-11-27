<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\InheritDocMergingReturn;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper26e51eeacccf\InheritDocMergingReturn\A
{
}
class C extends \_PhpScoper26e51eeacccf\InheritDocMergingReturn\B
{
}
class D extends \_PhpScoper26e51eeacccf\InheritDocMergingReturn\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoper26e51eeacccf\InheritDocMergingReturn\B();
    }
}
interface InterfaceC
{
    /** @return C */
    public function method();
}
interface InterfaceA
{
    /** @return A */
    public function method();
}
class ParentClass extends \_PhpScoper26e51eeacccf\InheritDocMergingReturn\GrandparentClass implements \_PhpScoper26e51eeacccf\InheritDocMergingReturn\InterfaceC, \_PhpScoper26e51eeacccf\InheritDocMergingReturn\InterfaceA
{
    /** Some comment */
    public function method()
    {
    }
}
class ChildClass extends \_PhpScoper26e51eeacccf\InheritDocMergingReturn\ParentClass
{
    public function method()
    {
    }
}
class ChildClass2 extends \_PhpScoper26e51eeacccf\InheritDocMergingReturn\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
    }
}
function (\_PhpScoper26e51eeacccf\InheritDocMergingReturn\ParentClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoper26e51eeacccf\InheritDocMergingReturn\ChildClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoper26e51eeacccf\InheritDocMergingReturn\ChildClass2 $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingReturn\\D', $foo->method());
};
