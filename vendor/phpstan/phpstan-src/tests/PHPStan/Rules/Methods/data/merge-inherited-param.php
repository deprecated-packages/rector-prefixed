<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited;

class A
{
}
class B extends \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\A
{
}
class C extends \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\B
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
class ParentClass extends \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
    }
}
class ChildClass extends \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
    }
}
function (\_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\ParentClass $foo) {
    $foo->method(new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\A(), new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\D(), new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\D());
    // expects A, B
};
function (\_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\ChildClass $foo) {
    $foo->method(new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\C(), new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\B(), new \_PhpScoper88fe6e0ad041\CallMethodsPhpDocMergeParamInherited\D());
    // expects C, B
};
