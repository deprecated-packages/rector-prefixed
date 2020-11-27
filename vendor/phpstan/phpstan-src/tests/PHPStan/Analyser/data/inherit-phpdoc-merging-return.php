<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\InheritDocMergingReturn;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\A
{
}
class C extends \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\B
{
}
class D extends \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\B();
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
class ParentClass extends \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\GrandparentClass implements \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\InterfaceC, \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\InterfaceA
{
    /** Some comment */
    public function method()
    {
    }
}
class ChildClass extends \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\ParentClass
{
    public function method()
    {
    }
}
class ChildClass2 extends \_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
    }
}
function (\_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\ParentClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\ChildClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoperbd5d0c5f7638\InheritDocMergingReturn\ChildClass2 $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingReturn\\D', $foo->method());
};
