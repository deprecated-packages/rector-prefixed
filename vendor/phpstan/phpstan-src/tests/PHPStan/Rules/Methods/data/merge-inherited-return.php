<?php

namespace _PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited;

class A
{
}
class B extends \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\A
{
}
class C extends \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\B
{
}
class D extends \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\B();
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
class ParentClass extends \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\GrandparentClass implements \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\InterfaceC, \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\InterfaceA
{
    /** Some comment */
    public function method()
    {
        return new \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass extends \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    public function method()
    {
        return new \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass2 extends \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
        return new \_PhpScoperabd03f0baf05\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
