<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited;

class A
{
}
class B extends \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\A
{
}
class C extends \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\B
{
}
class D
{
}
class GrandparentClass
{
    /** @param A $one */
    public function method($one, $two) : void
    {
    }
}
class ParentClass extends \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
    }
}
class ChildClass extends \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
    }
}
function (\_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\ParentClass $foo) {
    $foo->method(new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\A(), new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\D(), new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\D());
    // expects A, B
};
function (\_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\ChildClass $foo) {
    $foo->method(new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\C(), new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\B(), new \_PhpScoper006a73f0e455\CallMethodsPhpDocMergeParamInherited\D());
    // expects C, B
};
