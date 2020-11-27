<?php

namespace _PhpScoperbd5d0c5f7638\FinalAnnotations;

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
