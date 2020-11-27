<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\InheritDocMergingParam;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper26e51eeacccf\InheritDocMergingParam\A
{
}
class C extends \_PhpScoper26e51eeacccf\InheritDocMergingParam\B
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \_PhpScoper26e51eeacccf\InheritDocMergingParam\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingParam\\A', $uno);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingParam\\B', $dos);
    }
}
class ChildClass extends \_PhpScoper26e51eeacccf\InheritDocMergingParam\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingParam\\C', $one);
        \PHPStan\Analyser\assertType('_PhpScoper26e51eeacccf\\InheritDocMergingParam\\B', $two);
    }
}
