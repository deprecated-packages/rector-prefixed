<?php

namespace _PhpScoper26e51eeacccf\Bug3641;

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
        $instance = new \_PhpScoper26e51eeacccf\Bug3641\Foo();
        return $instance->{$method}(...$args);
    }
}
function () : void {
    \_PhpScoper26e51eeacccf\Bug3641\Bar::bar();
    \_PhpScoper26e51eeacccf\Bug3641\Bar::bar(1);
};
