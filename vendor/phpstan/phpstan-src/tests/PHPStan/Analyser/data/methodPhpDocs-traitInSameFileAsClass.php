<?php

namespace _PhpScoper006a73f0e455\MethodPhpDocsTraitInSameFileAsClass;

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
