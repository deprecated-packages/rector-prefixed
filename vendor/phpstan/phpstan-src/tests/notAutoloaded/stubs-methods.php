<?php

namespace _PhpScoper26e51eeacccf\StubsIntegrationTest;

use _PhpScoper26e51eeacccf\RecursiveTemplateProblem\Collection;
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
    public function doFoo(\_PhpScoper26e51eeacccf\RecursiveTemplateProblem\Collection $collection) : void
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
class ClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoper26e51eeacccf\StubsIntegrationTest\InterfaceWithStubPhpDoc
{
}
class AnotherClassExtendingInterfaceWithStubPhpDoc implements \_PhpScoper26e51eeacccf\StubsIntegrationTest\InterfaceWithStubPhpDoc
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
