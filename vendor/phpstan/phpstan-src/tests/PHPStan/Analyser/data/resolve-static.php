<?php

namespace _PhpScoperabd03f0baf05\ResolveStatic;

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
class Bar extends \_PhpScoperabd03f0baf05\ResolveStatic\Foo
{
}
function (\_PhpScoperabd03f0baf05\ResolveStatic\Bar $bar) {
    die;
};
