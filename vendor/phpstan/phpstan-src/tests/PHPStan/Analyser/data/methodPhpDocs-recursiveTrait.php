<?php

namespace _PhpScoper006a73f0e455\MethodPhpDocsNamespace;

use _PhpScoper006a73f0e455\SomeNamespace\Amet as Dolor;
use _PhpScoper006a73f0e455\SomeNamespace\Consecteur;
trait RecursiveFooTrait
{
    use FooTrait;
}
class FooWithRecursiveTrait extends \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\FooParent
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
    public function returnParent() : \_PhpScoper006a73f0e455\parent
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
