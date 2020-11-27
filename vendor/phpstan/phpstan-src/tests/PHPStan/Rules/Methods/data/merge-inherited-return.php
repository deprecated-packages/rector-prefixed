<?php

namespace _PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited;

class A
{
}
class B extends \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\A
{
}
class C extends \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\B
{
}
class D extends \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\B();
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
class ParentClass extends \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\GrandparentClass implements \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\InterfaceC, \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\InterfaceA
{
    /** Some comment */
    public function method()
    {
        return new \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass extends \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    public function method()
    {
        return new \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass2 extends \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
        return new \_PhpScoperbd5d0c5f7638\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
