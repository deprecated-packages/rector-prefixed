<?php

namespace _PhpScopera143bcca66cb\MethodPhpDocsNamespace;

use _PhpScopera143bcca66cb\SomeNamespace\Amet as Dolor;
use _PhpScopera143bcca66cb\SomeNamespace\Consecteur;
class FooWithTrait extends \_PhpScopera143bcca66cb\MethodPhpDocsNamespace\FooParent
{
    use FooTrait;
    /**
     * @return Bar
     */
    public static function doSomethingStatic()
    {
    }
    /**
     * @return self[]
     */
    public function doBar() : array
    {
    }
    public function returnParent() : \_PhpScopera143bcca66cb\parent
    {
    }
    /**
     * @return parent
     */
    public function returnPhpDocParent()
    {
    }
    /**
     * @return NULL[]
     */
    public function returnNulls() : array
    {
    }
    public function returnObject() : object
    {
    }
    public function phpDocVoidMethod() : self
    {
    }
    public function phpDocVoidMethodFromInterface() : self
    {
    }
    public function phpDocVoidParentMethod() : self
    {
    }
    public function phpDocWithoutCurlyBracesVoidParentMethod() : self
    {
    }
    /**
     * @return string[]
     */
    public function returnsStringArray() : array
    {
    }
    private function privateMethodWithPhpDoc()
    {
    }
}
