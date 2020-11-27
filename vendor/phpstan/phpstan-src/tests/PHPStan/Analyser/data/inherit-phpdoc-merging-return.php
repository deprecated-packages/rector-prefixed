<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\InheritDocMergingReturn;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\A
{
}
class C extends \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\B
{
}
class D extends \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\B();
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
class ParentClass extends \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\GrandparentClass implements \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\InterfaceC, \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\InterfaceA
{
    /** Some comment */
    public function method()
    {
    }
}
class ChildClass extends \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\ParentClass
{
    public function method()
    {
    }
}
class ChildClass2 extends \_PhpScoper88fe6e0ad041\InheritDocMergingReturn\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
    }
}
function (\_PhpScoper88fe6e0ad041\InheritDocMergingReturn\ParentClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoper88fe6e0ad041\InheritDocMergingReturn\ChildClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoper88fe6e0ad041\InheritDocMergingReturn\ChildClass2 $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingReturn\\D', $foo->method());
};
