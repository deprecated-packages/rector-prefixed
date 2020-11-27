<?php

namespace _PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace;

use _PhpScoperbd5d0c5f7638\SomeNamespace\Amet as Dolor;
use _PhpScoperbd5d0c5f7638\SomeNamespace\Consecteur;
trait RecursiveFooTrait
{
    use FooTrait;
}
class FooWithRecursiveTrait extends \_PhpScoperbd5d0c5f7638\MethodPhpDocsNamespace\FooParent
{
    use RecursiveFooTrait;
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
    public function returnParent() : \_PhpScoperbd5d0c5f7638\parent
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
