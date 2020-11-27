<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited;

class A
{
}
class B extends \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\A
{
}
class C extends \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\B
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
class ParentClass extends \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
    }
}
class ChildClass extends \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
    }
}
function (\_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\ParentClass $foo) {
    $foo->method(new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\A(), new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\D(), new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\D());
    // expects A, B
};
function (\_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\ChildClass $foo) {
    $foo->method(new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\C(), new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\B(), new \_PhpScoperbd5d0c5f7638\CallMethodsPhpDocMergeParamInherited\D());
    // expects C, B
};
