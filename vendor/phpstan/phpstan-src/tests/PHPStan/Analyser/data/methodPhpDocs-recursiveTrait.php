<?php

namespace _PhpScoper26e51eeacccf\MethodPhpDocsNamespace;

use _PhpScoper26e51eeacccf\SomeNamespace\Amet as Dolor;
use _PhpScoper26e51eeacccf\SomeNamespace\Consecteur;
trait RecursiveFooTrait
{
    use FooTrait;
}
class FooWithRecursiveTrait extends \_PhpScoper26e51eeacccf\MethodPhpDocsNamespace\FooParent
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
    public function returnParent() : \_PhpScoper26e51eeacccf\parent
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
