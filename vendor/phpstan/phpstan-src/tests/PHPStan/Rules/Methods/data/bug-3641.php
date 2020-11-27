<?php

namespace _PhpScoperbd5d0c5f7638\Bug3641;

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
        $instance = new \_PhpScoperbd5d0c5f7638\Bug3641\Foo();
        return $instance->{$method}(...$args);
    }
}
function () : void {
    \_PhpScoperbd5d0c5f7638\Bug3641\Bar::bar();
    \_PhpScoperbd5d0c5f7638\Bug3641\Bar::bar(1);
};
