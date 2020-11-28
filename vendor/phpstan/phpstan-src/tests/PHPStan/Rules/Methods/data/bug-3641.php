<?php

namespace _PhpScoperabd03f0baf05\Bug3641;

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
        $instance = new \_PhpScoperabd03f0baf05\Bug3641\Foo();
        return $instance->{$method}(...$args);
    }
}
function () : void {
    \_PhpScoperabd03f0baf05\Bug3641\Bar::bar();
    \_PhpScoperabd03f0baf05\Bug3641\Bar::bar(1);
};
