<?php

namespace _PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited;

class A
{
}
class B extends \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\A
{
}
class C extends \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\B
{
}
class D extends \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\B();
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
class ParentClass extends \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\GrandparentClass implements \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\InterfaceC, \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\InterfaceA
{
    /** Some comment */
    public function method()
    {
        return new \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass extends \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    public function method()
    {
        return new \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass2 extends \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
        return new \_PhpScoper006a73f0e455\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
