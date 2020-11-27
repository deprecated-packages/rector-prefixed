<?php

namespace _PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace;

use _PhpScoperbd5d0c5f7638\SomeNamespace\Amet as Dolor;
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
    public function doFluentUnionIterable() : \_PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace\Collection
    {
    }
}
