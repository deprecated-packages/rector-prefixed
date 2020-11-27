<?php

namespace _PhpScoperbd5d0c5f7638\StubsIntegrationTest;

use _PhpScoperbd5d0c5f7638\RecursiveTemplateProblem\Collection;
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
    public function doFoo(\_PhpScoperbd5d0c5f7638\RecursiveTemplateProblem\Collection $collection) : void
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
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoperbd5d0c5f7638\StubsIntegrationTest\InterfaceWithStubPhpDoc
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
