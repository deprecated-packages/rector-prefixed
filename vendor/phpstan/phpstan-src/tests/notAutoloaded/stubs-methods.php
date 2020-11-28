<?php

namespace _PhpScoperabd03f0baf05\StubsIntegrationTest;

use _PhpScoperabd03f0baf05\RecursiveTemplateProblem\Collection;
class Foo
{
    /**
     * @param int $i
     * @return string
     */
    public function doFoo($i)
    {
        return '';
    }
}
class Bar
{
    /**
     * @param \RecursiveTemplateProblem\Collection<int, Foo> $collection
     */
    public function doFoo(\_PhpScoperabd03f0baf05\RecursiveTemplateProblem\Collection $collection) : void
    {
        $collection->partition(function ($key, $value) : bool {
            return \true;
        });
    }
}
interface InterfaceWithStubPhpDoc
{
    /**
     * @return int
     */
    public function doFoo();
}
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperabd03f0baf05\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
interface InterfaceWithStubPhpDoc2
{
    /**
     * @return int
     */
    public function doFoo();
}
class YetAnotherFoo
{
    /**
     * @param int $i
     * @return string
     */
    public function doFoo($i)
    {
        return '';
    }
}
class YetYetAnotherFoo
{
    /**
     * @param int $i
     * @return string
     */
    public function doFoo($i)
    {
        return '';
    }
}
