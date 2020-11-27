<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\InheritDocMergingParam;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScopera143bcca66cb\InheritDocMergingParam\A
{
}
class C extends \_PhpScopera143bcca66cb\InheritDocMergingParam\B
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \_PhpScopera143bcca66cb\InheritDocMergingParam\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingParam\\A', $uno);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingParam\\B', $dos);
    }
}
class ChildClass extends \_PhpScopera143bcca66cb\InheritDocMergingParam\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingParam\\C', $one);
        \PHPStan\Analyser\assertType('_PhpScopera143bcca66cb\\InheritDocMergingParam\\B', $two);
    }
}
