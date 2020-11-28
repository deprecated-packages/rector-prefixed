<?php

namespace _PhpScoperabd03f0baf05\MethodPhpDocsNamespace;

use _PhpScoperabd03f0baf05\SomeNamespace\Amet as Dolor;
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
    public function doFluentUnionIterable() : \_PhpScoperabd03f0baf05\MethodPhpDocsNamespace\Collection
    {
    }
}
