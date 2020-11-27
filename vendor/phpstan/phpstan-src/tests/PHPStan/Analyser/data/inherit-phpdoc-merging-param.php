<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\InheritDocMergingParam;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoperbd5d0c5f7638\InheritDocMergingParam\A
{
}
class C extends \_PhpScoperbd5d0c5f7638\InheritDocMergingParam\B
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \_PhpScoperbd5d0c5f7638\InheritDocMergingParam\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingParam\\A', $uno);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingParam\\B', $dos);
    }
}
class ChildClass extends \_PhpScoperbd5d0c5f7638\InheritDocMergingParam\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingParam\\C', $one);
        \PHPStan\Analyser\assertType('_PhpScoperbd5d0c5f7638\\InheritDocMergingParam\\B', $two);
    }
}
