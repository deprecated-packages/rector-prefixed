<?php

namespace _PhpScopera143bcca66cb\StubsIntegrationTest;

class Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\Foo $foo) {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class FooChild extends \_PhpScopera143bcca66cb\StubsIntegrationTest\Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\FooChild $fooChild) {
    $string = $fooChild->doFoo('test');
    $fooChild->doFoo($string);
};
interface InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo();
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceExtendingInterfaceWithStubPhpDoc extends \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface AnotherInterfaceExtendingInterfaceWithStubPhpDoc extends \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo();
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\AnotherInterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\ClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\AnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
/** This one is missing in the stubs */
class YetAnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\YetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceWithStubPhpDoc2
{
    public function doFoo();
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 implements \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc2
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherFooChild extends \_PhpScopera143bcca66cb\StubsIntegrationTest\Foo
{
    public function doFoo($j)
    {
        return '';
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\AnotherFooChild $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class YetAnotherFoo
{
    public function doFoo($j)
    {
        return '';
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\YetAnotherFoo $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class YetYetAnotherFoo
{
    /**
     * Deliberately wrong phpDoc
     * @param \stdClass $j
     * @return \stdClass
     */
    public function doFoo($j)
    {
        return '';
    }
}
function (\_PhpScopera143bcca66cb\StubsIntegrationTest\YetYetAnotherFoo $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
