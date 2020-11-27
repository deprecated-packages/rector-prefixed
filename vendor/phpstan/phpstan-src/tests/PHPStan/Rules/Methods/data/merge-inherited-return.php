<?php

namespace _PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited;

class A
{
}
class B extends \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\A
{
}
class C extends \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\B
{
}
class D extends \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
interface InterfaceC
{
    /** @return C */
    public function method();
}
interface InterfaceA
{
    /** @return A */
    public function method();
}
class ParentClass extends \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\GrandparentClass implements \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\InterfaceC, \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\InterfaceA
{
    /** Some comment */
    public function method()
    {
        return new \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass extends \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    public function method()
    {
        return new \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass2 extends \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
        return new \_PhpScopera143bcca66cb\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
