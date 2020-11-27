<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited;

class A
{
}
class B extends \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\A
{
}
class C extends \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\B
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
class ParentClass extends \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
    }
}
class ChildClass extends \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
    }
}
function (\_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\ParentClass $foo) {
    $foo->method(new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\A(), new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\D(), new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\D());
    // expects A, B
};
function (\_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\ChildClass $foo) {
    $foo->method(new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\C(), new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\B(), new \_PhpScoper26e51eeacccf\CallMethodsPhpDocMergeParamInherited\D());
    // expects C, B
};
