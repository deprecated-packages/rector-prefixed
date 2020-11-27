<?php

namespace _PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited;

class A
{
}
class B extends \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\A
{
}
class C extends \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\B
{
}
class D extends \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\B();
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
class ParentClass extends \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\GrandparentClass implements \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\InterfaceC, \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\InterfaceA
{
    /** Some comment */
    public function method()
    {
        return new \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass extends \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    public function method()
    {
        return new \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass2 extends \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
        return new \_PhpScoper88fe6e0ad041\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
