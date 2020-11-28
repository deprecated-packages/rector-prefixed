<?php

namespace _PhpScoperabd03f0baf05\StubsIntegrationTest;

class Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\Foo $foo) {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
class FooChild extends \_PhpScoperabd03f0baf05\StubsIntegrationTest\Foo
{
    public function doFoo($i)
    {
        return '';
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\FooChild $fooChild) {
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
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceExtendingInterfaceWithStubPhpDoc extends \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface AnotherInterfaceExtendingInterfaceWithStubPhpDoc extends \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo();
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\AnotherInterfaceExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\ClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\AnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
/** This one is missing in the stubs */
class YetAnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    /**
     * @return string
     */
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\YetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    return $stub->doFoo();
    // implementation wins - string -> int mismatch reported
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
interface InterfaceWithStubPhpDoc2
{
    public function doFoo();
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 implements \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc2
{
    public function doFoo()
    {
        throw new \Exception();
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\YetYetAnotherClassExtendingInterfaceWithStubPhpDoc2 $stub) : int {
    // return int should be inherited
    $stub->doFoo() === [];
    return $stub->doFoo();
    // stub wins
};
class AnotherFooChild extends \_PhpScoperabd03f0baf05\StubsIntegrationTest\Foo
{
    public function doFoo($j)
    {
        return '';
    }
}
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\AnotherFooChild $foo) : void {
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
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\YetAnotherFoo $foo) : void {
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
function (\_PhpScoperabd03f0baf05\StubsIntegrationTest\YetYetAnotherFoo $foo) : void {
    $string = $foo->doFoo('test');
    $foo->doFoo($string);
};
