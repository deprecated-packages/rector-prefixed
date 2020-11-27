<?php

namespace _PhpScoper006a73f0e455\MethodPhpDocsNamespace;

use _PhpScoper006a73f0e455\SomeNamespace\Amet as Dolor;
class Bar
{
    /**
     * @return self
     */
    public function doBar()
    {
    }
    /**
     * @return static
     */
    public function doFluent()
    {
    }
    /**
     * @return static|null
     */
    public function doFluentNullable()
    {
    }
    /**
     * @return static[]
     */
    public function doFluentArray() : array
    {
    }
    /**
     * @return static[]|Collection
     */
    public function doFluentUnionIterable() : \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\Collection
    {
    }
}
