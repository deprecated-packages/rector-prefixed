<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\InheritDocMergingParam;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper88fe6e0ad041\InheritDocMergingParam\A
{
}
class C extends \_PhpScoper88fe6e0ad041\InheritDocMergingParam\B
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \_PhpScoper88fe6e0ad041\InheritDocMergingParam\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingParam\\A', $uno);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingParam\\B', $dos);
    }
}
class ChildClass extends \_PhpScoper88fe6e0ad041\InheritDocMergingParam\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingParam\\C', $one);
        \PHPStan\Analyser\assertType('_PhpScoper88fe6e0ad041\\InheritDocMergingParam\\B', $two);
    }
}
