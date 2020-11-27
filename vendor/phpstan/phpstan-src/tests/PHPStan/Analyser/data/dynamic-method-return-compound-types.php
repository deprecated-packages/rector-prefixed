<?php

namespace _PhpScoper006a73f0e455\DynamicMethodReturnCompoundTypes;

class Collection
{
    public function getSelf()
    {
    }
}
class Foo
{
    public function getSelf()
    {
    }
    /**
     * @param Collection|Foo[] $collection
     * @param Collection|Foo $collectionOrFoo
     */
    public function doFoo($collection, $collectionOrFoo)
    {
        die;
    }
}
