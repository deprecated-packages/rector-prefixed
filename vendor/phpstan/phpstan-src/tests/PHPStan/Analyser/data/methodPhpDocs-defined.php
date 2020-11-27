<?php

namespace _PhpScopera143bcca66cb\MethodPhpDocsNamespace;

use _PhpScopera143bcca66cb\SomeNamespace\Amet as Dolor;
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
    public function doFluentUnionIterable() : \_PhpScopera143bcca66cb\MethodPhpDocsNamespace\Collection
    {
    }
}
