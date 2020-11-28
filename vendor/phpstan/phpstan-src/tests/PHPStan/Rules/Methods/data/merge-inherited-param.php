<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited;

class A
{
}
class B extends \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\A
{
}
class C extends \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\B
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
class ParentClass extends \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\GrandparentClass
{
    /** @param B $dos */
    public function method($uno, $dos) : void
    {
    }
}
class ChildClass extends \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\ParentClass
{
    /** @param C $one */
    public function method($one, $two) : void
    {
    }
}
function (\_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\ParentClass $foo) {
    $foo->method(new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\A(), new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\D(), new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\D());
    // expects A, B
};
function (\_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\ChildClass $foo) {
    $foo->method(new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\C(), new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\B());
    // ok
    $foo->method(new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\B(), new \_PhpScoperabd03f0baf05\CallMethodsPhpDocMergeParamInherited\D());
    // expects C, B
};
