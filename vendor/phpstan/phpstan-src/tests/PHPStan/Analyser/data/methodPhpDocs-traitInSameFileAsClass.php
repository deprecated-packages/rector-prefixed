<?php

namespace _PhpScoper26e51eeacccf\MethodPhpDocsTraitInSameFileAsClass;

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
