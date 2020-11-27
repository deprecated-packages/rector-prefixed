<?php

namespace _PhpScoper006a73f0e455\ResolveStatic;

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
class Bar extends \_PhpScoper006a73f0e455\ResolveStatic\Foo
{
}
function (\_PhpScoper006a73f0e455\ResolveStatic\Bar $bar) {
    die;
};
