<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\InheritDocMergingReturn;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScopera143bcca66cb\InheritDocMergingReturn\A
{
}
class C extends \_PhpScopera143bcca66cb\InheritDocMergingReturn\B
{
}
class D extends \_PhpScopera143bcca66cb\InheritDocMergingReturn\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScopera143bcca66cb\InheritDocMergingReturn\B();
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
class ParentClass extends \_PhpScopera143bcca66cb\InheritDocMergingReturn\GrandparentClass implements \_PhpScopera143bcca66cb\InheritDocMergingReturn\InterfaceC, \_PhpScopera143bcca66cb\InheritDocMergingReturn\InterfaceA
{
    /** Some comment */
    public function method()
    {
    }
}
class ChildClass extends \_PhpScopera143bcca66cb\InheritDocMergingReturn\ParentClass
{
    public function method()
    {
    }
}
class ChildClass2 extends \_PhpScopera143bcca66cb\InheritDocMergingReturn\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
    }
}
function (\_PhpScopera143bcca66cb\InheritDocMergingReturn\ParentClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScopera143bcca66cb\InheritDocMergingReturn\ChildClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScopera143bcca66cb\InheritDocMergingReturn\ChildClass2 $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingReturn\\D', $foo->method());
};
