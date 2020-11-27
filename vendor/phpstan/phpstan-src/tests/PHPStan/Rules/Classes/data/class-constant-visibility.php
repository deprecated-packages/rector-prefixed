<?php

// lint < 8.0
namespace _PhpScopera143bcca66cb\ClassConstantVisibility;

class Foo
{
    const PUBLIC_CONST_FOO = 1;
    private const PRIVATE_FOO = 1;
    protected const PROTECTED_FOO = 1;
    public const ANOTHER_PUBLIC_CONST_FOO = 1;
    public function doFoo()
    {
        self::PUBLIC_CONST_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::PUBLIC_CONST_FOO;
        self::PRIVATE_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::PRIVATE_FOO;
        self::PROTECTED_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::PROTECTED_FOO;
        self::ANOTHER_PUBLIC_CONST_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::ANOTHER_PUBLIC_CONST_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Bar::PUBLIC_CONST_BAR;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Bar::ANOTHER_PUBLIC_CONST_BAR;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Bar::PRIVATE_BAR;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Bar::PROTECTED_BAR;
        parent::BAZ;
    }
}
class Bar extends \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo
{
    const PUBLIC_CONST_BAR = 1;
    private const PRIVATE_BAR = 1;
    protected const PROTECTED_BAR = 1;
    public const ANOTHER_PUBLIC_CONST_BAR = 1;
    public function doBar()
    {
        self::PUBLIC_CONST_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::PUBLIC_CONST_FOO;
        parent::PUBLIC_CONST_FOO;
        self::PRIVATE_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::PRIVATE_FOO;
        parent::PRIVATE_FOO;
        self::PROTECTED_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::PROTECTED_FOO;
        parent::PROTECTED_FOO;
        self::ANOTHER_PUBLIC_CONST_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Foo::ANOTHER_PUBLIC_CONST_FOO;
        parent::ANOTHER_PUBLIC_CONST_FOO;
        $bar = new self();
        $bar::PUBLIC_CONST_BAR;
        $bar::PROTECTED_BAR;
        $bar::PRIVATE_BAR;
        $bar::PUBLIC_CONST_FOO;
        $bar::PRIVATE_FOO;
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Self::PUBLIC_CONST_BAR;
    }
}
class Baz
{
    public function doBaz()
    {
        \_PhpScopera143bcca66cb\ClassConstantVisibility\Bar::PROTECTED_FOO;
    }
}
class WithFooConstant
{
    const FOO = 'foo';
}
interface WithFooAndBarConstant
{
    const FOO = 'foo';
    const BAR = 'bar';
}
class Ipsum
{
    /** @var WithFooAndBarConstant|WithFooConstant */
    private $union;
    /** @var UnknownClassFirst|UnknownClassSecond */
    private $unknown;
    public function doIpsum(\_PhpScopera143bcca66cb\ClassConstantVisibility\WithFooConstant $foo)
    {
        if ($foo instanceof \_PhpScopera143bcca66cb\ClassConstantVisibility\WithFooAndBarConstant) {
            $foo::FOO;
            $foo::BAR;
            $foo::BAZ;
        }
        $this->union::FOO;
        $this->union::BAR;
        $this->unknown::FOO;
        /** @var string|int $stringOrInt */
        $stringOrInt = doFoo();
        $stringOrInt::FOO;
    }
}
function () {
    \_PhpScopera143bcca66cb\ClassConstantVisibility\FOO::PRIVATE_FOO;
};
