<?php

namespace _PhpScoperabd03f0baf05\MethodPhpDocsNamespace;

use _PhpScoperabd03f0baf05\SomeNamespace\Amet as Dolor;
use _PhpScoperabd03f0baf05\SomeNamespace\Consecteur;
class FooWithTrait extends \_PhpScoperabd03f0baf05\MethodPhpDocsNamespace\FooParent
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
    public function returnParent() : \_PhpScoperabd03f0baf05\parent
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
