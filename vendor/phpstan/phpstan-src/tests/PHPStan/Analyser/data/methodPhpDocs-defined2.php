<?php

namespace _PhpScoper006a73f0e455\MethodPhpDocsNamespace;

use _PhpScoper006a73f0e455\SomeNamespace\Amet as Dolor;
interface FooInterface
{
    /**
     * @return void
     */
    public function phpDocVoidMethodFromInterface();
}
class FooParentParent
{
    /**
     * @return void
     */
    public function phpDocVoidParentMethod()
    {
    }
    /**
     * @return void
     */
    public function phpDocWithoutCurlyBracesVoidParentMethod()
    {
    }
}
abstract class FooParent extends \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\FooParentParent implements \_PhpScoper006a73f0e455\MethodPhpDocsNamespace\FooInterface
{
    /**
     * @return Static
     */
    public function doLorem()
    {
    }
    /**
     * @return static
     */
    public function doIpsum() : self
    {
    }
    /**
     * @return $this
     */
    public function doThis()
    {
        return $this;
    }
    /**
     * @return $this|null
     */
    public function doThisNullable()
    {
        return $this;
    }
    /**
     * @return $this|Bar|null
     */
    public function doThisUnion()
    {
    }
    /**
     * @return void
     */
    public function phpDocVoidMethod()
    {
    }
    /**
     * {@inheritDoc}
     */
    public function phpDocVoidParentMethod()
    {
    }
    /**
     * @inheritDoc
     */
    public function phpDocWithoutCurlyBracesVoidParentMethod()
    {
    }
    /**
     * @return string[]
     */
    private function privateMethodWithPhpDoc()
    {
    }
}
