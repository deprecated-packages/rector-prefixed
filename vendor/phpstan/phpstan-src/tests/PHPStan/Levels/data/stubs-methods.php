<?php

namespace _PhpScoperbd5d0c5f7638\StubsIntegrationTest;

class Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\Foo $foo) {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class FooChild extends \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\FooChild $fooChild) {
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
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceExtendingInterfaceWithStubPhpDoc extends \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface AnotherInterfaceExtendingInterfaceWithStubPhpDoc extends \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo();
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\AnotherInterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\ClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\AnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
/** This one is missing in the stubs */
class YetAnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\YetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceWithStubPhpDoc2
{
    public function doFoo();
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 implements \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc2
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherFooChild extends \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\Foo
{
    public function doFoo($j)
    {
        return '';
    }
}
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\AnotherFooChild $foo) : void {
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
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\YetAnotherFoo $foo) : void {
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
function (\_PhpScoperbd5d0c5f7638\StubsIntegrationTest\YetYetAnotherFoo $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
