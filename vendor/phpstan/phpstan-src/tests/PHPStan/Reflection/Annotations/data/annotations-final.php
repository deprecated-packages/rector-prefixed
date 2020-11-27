<?php

namespace _PhpScoper006a73f0e455\FinalAnnotations;

function foo()
{
}
/**
 * @final
 */
function finalFoo()
{
}
class Foo
{
    public function foo()
    {
    }
    public static function staticFoo()
    {
    }
}
/**
 * @final
 */
class FinalFoo
{
    /**
     * @final
     */
    public function finalFoo()
    {
    }
    /**
     * @final
     */
    public static function finalStaticFoo()
    {
    }
}
