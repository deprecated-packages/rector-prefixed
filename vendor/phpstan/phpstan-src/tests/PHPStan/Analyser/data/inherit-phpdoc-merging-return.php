<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\InheritDocMergingReturn;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoperabd03f0baf05\InheritDocMergingReturn\A
{
}
class C extends \_PhpScoperabd03f0baf05\InheritDocMergingReturn\B
{
}
class D extends \_PhpScoperabd03f0baf05\InheritDocMergingReturn\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoperabd03f0baf05\InheritDocMergingReturn\B();
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
class ParentClass extends \_PhpScoperabd03f0baf05\InheritDocMergingReturn\GrandparentClass implements \_PhpScoperabd03f0baf05\InheritDocMergingReturn\InterfaceC, \_PhpScoperabd03f0baf05\InheritDocMergingReturn\InterfaceA
{
    /** Some comment */
    public function method()
    {
    }
}
class ChildClass extends \_PhpScoperabd03f0baf05\InheritDocMergingReturn\ParentClass
{
    public function method()
    {
    }
}
class ChildClass2 extends \_PhpScoperabd03f0baf05\InheritDocMergingReturn\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
    }
}
function (\_PhpScoperabd03f0baf05\InheritDocMergingReturn\ParentClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoperabd03f0baf05\InheritDocMergingReturn\ChildClass $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\InheritDocMergingReturn\\B', $foo->method());
};
function (\_PhpScoperabd03f0baf05\InheritDocMergingReturn\ChildClass2 $foo) : void {
    \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\InheritDocMergingReturn\\D', $foo->method());
};
