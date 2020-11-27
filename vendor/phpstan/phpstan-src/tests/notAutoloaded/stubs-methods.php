<?php

namespace _PhpScoper006a73f0e455\StubsIntegrationTest;

use _PhpScoper006a73f0e455\RecursiveTemplateProblem\Collection;
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
    public function doFoo(\_PhpScoper006a73f0e455\RecursiveTemplateProblem\Collection $collection) : void
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
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoper006a73f0e455\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoper006a73f0e455\StubsIntegrationTest\InterfaceWithStubPhpDoc
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
