<?php

namespace _PhpScoperbd5d0c5f7638\MethodPhpDocsTraitInSameFileAsClass;

trait FooTrait
{
    /**
     * @return string
     */
    public function getFoo()
    {
        return 'foo';
    }
}
class Foo
{
    use FooTrait;
    public function bar()
    {
        die;
    }
}
