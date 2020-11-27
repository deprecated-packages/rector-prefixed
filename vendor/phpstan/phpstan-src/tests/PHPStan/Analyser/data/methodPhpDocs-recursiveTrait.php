<?php

namespace _PhpScoper88fe6e0ad041\MethodPhpDocsNamespace;

use _PhpScoper88fe6e0ad041\SomeNamespace\Amet as Dolor;
use _PhpScoper88fe6e0ad041\SomeNamespace\Consecteur;
trait RecursiveFooTrait
{
    use FooTrait;
}
class FooWithRecursiveTrait extends \_PhpScoper88fe6e0ad041\MethodPhpDocsNamespace\FooParent
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
    public function returnParent() : \_PhpScoper88fe6e0ad041\parent
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
