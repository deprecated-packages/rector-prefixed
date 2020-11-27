<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited;

class A
{
}
class B extends \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\A
{
}
class C extends \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\B
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
class ParentClass extends \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
    }
}
class ChildClass extends \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
    }
}
function (\_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\ParentClass $foo) {
    $foo->method(new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\A(), new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\D(), new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\D());
    // expects A, B
};
function (\_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\ChildClass $foo) {
    $foo->method(new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\C(), new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\B(), new \_PhpScopera143bcca66cb\CallMethodsPhpDocMergeParamInherited\D());
    // expects C, B
};
