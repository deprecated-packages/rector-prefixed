<?php

namespace _PhpScoper88fe6e0ad041\MethodPhpDocsNamespace;

use _PhpScoper88fe6e0ad041\SomeNamespace\Amet as Dolor;
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
    public function doFluentUnionIterable() : \_PhpScoper88fe6e0ad041\MethodPhpDocsNamespace\Collection
    {
    }
}
