<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\InheritDocMergingParam;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoperabd03f0baf05\InheritDocMergingParam\A
{
}
class C extends \_PhpScoperabd03f0baf05\InheritDocMergingParam\B
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \_PhpScoperabd03f0baf05\InheritDocMergingParam\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\InheritDocMergingParam\\A', $uno);
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\InheritDocMergingParam\\B', $dos);
    }
}
class ChildClass extends \_PhpScoperabd03f0baf05\InheritDocMergingParam\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\InheritDocMergingParam\\C', $one);
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\InheritDocMergingParam\\B', $two);
    }
}
