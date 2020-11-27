<?php

namespace _PhpScoper88fe6e0ad041\MethodPhpDocsTraitInSameFileAsClass;

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
