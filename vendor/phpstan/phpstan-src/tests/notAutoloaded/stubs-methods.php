<?php

namespace _PhpScopera143bcca66cb\StubsIntegrationTest;

use _PhpScopera143bcca66cb\RecursiveTemplateProblem\Collection;
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
    public function doFoo(\_PhpScopera143bcca66cb\RecursiveTemplateProblem\Collection $collection) : void
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
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScopera143bcca66cb\StubsIntegrationTest\InterfaceWithStubPhpDoc
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
