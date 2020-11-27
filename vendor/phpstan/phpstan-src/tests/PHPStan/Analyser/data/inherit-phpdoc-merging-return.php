<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\InheritDocMergingReturn;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper006a73f0e455\InheritDocMergingReturn\A
{
}
class C extends \_PhpScoper006a73f0e455\InheritDocMergingReturn\B
{
}
class D extends \_PhpScoper006a73f0e455\InheritDocMergingReturn\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoper006a73f0e455\InheritDocMergingReturn\B();
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
class ParentClass extends \_PhpScoper006a73f0e455\InheritDocMergingReturn\GrandparentClass implements \_PhpScoper006a73f0e455\InheritDocMergingReturn\InterfaceC, \_PhpScoper006a73f0e455\InheritDocMergingReturn\InterfaceA
{
    /** Some comment */
    public function method()
    {
    }
}
class ChildClass extends \_PhpScoper006a73f0e455\InheritDocMergingReturn\ParentClass
{
    public function method()
    {
    }
}
class ChildClass2 extends \_PhpScoper006a73f0e455\InheritDocMergingReturn\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
    }
}
function (\_PhpScoper006a73f0e455\InheritDocMergingReturn\ParentClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoper006a73f0e455\InheritDocMergingReturn\ChildClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoper006a73f0e455\InheritDocMergingReturn\ChildClass2 $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingReturn\\D', $foo->method());
};
