<?php

namespace _PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited;

class A
{
}
class B extends \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\A
{
}
class C extends \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\B
{
}
class D extends \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\A
{
}
class GrandparentClass
{
    /** @return B */
    public function method()
    {
        return new \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\B();
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
class ParentClass extends \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\GrandparentClass implements \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\InterfaceC, \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\InterfaceA
{
    /** Some comment */
    public function method()
    {
        return new \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass extends \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    public function method()
    {
        return new \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\A();
    }
}
class ChildClass2 extends \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\ParentClass
{
    /**
     * @return D
     */
    public function method()
    {
        return new \_PhpScoper26e51eeacccf\ReturnTypePhpDocMergeReturnInherited\B();
    }
}
