<?php

namespace _PhpScoperbd5d0c5f7638\ResolveStatic;

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
class Bar extends \_PhpScoperbd5d0c5f7638\ResolveStatic\Foo
{
}
function (\_PhpScoperbd5d0c5f7638\ResolveStatic\Bar $bar) {
    die;
};
