<?php

namespace _PhpScopera143bcca66cb\Bug3641;

class Foo
{
    public function bar() : int
    {
        return 5;
    }
}
/**
 * @mixin Foo
 */
class Bar
{
    /**
     * @param  mixed[]  $args
     * @return mixed
     */
    public static function __callStatic(string $method, $args)
    {
        $instance = new \_PhpScopera143bcca66cb\Bug3641\Foo();
        return $instance->{$method}(...$args);
    }
}
function () : void {
    \_PhpScopera143bcca66cb\Bug3641\Bar::bar();
    \_PhpScopera143bcca66cb\Bug3641\Bar::bar(1);
};
