<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\InheritDocMergingParam;

use function PHPStan\Analyser\assertType;
class A
{
}
class B extends \_PhpScoper006a73f0e455\InheritDocMergingParam\A
{
}
class C extends \_PhpScoper006a73f0e455\InheritDocMergingParam\B
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \_PhpScoper006a73f0e455\InheritDocMergingParam\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingParam\\A', $uno);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingParam\\B', $dos);
    }
}
class ChildClass extends \_PhpScoper006a73f0e455\InheritDocMergingParam\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingParam\\C', $one);
        \PHPStan\Analyser\assertType('_PhpScoper006a73f0e455\\InheritDocMergingParam\\B', $two);
    }
}
