<?php

namespace _PhpScoperbd5d0c5f7638\DynamicMethodReturnCompoundTypes;

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
