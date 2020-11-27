<?php

namespace _PhpScoper26e51eeacccf\ResolveStatic;

class Foo
{
    /**
     * @return static
     */
    public static function create()
    {
        return new static();
    }
    /**
     * @return array{foo: static}
     */
    public function returnConstantArray() : array
    {
        return [$this];
    }
    /**
     * @return static
     */
    public function nullabilityNotInSync() : ?self
    {
    }
    /**
     * @return static|null
     */
    public function anotherNullabilityNotInSync() : self
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\ResolveStatic\Foo
{
}
function (\_PhpScoper26e51eeacccf\ResolveStatic\Bar $bar) {
    die;
};
