<?php

namespace _PhpScopera143bcca66cb\MethodPhpDocsTraitInSameFileAsClass;

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
