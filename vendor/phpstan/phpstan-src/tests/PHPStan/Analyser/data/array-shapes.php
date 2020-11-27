<?php

namespace _PhpScoper006a73f0e455\ArrayShapesInPhpDoc;

class Foo
{
    /**
     * @param array{0: string, 1: Foo, foo:Bar, Baz} $one
     * @param array{0: string, 1?: Foo, foo?:Bar} $two
     * @param array{0?: string, 1?: Foo, foo?:Bar} $three
     */
    public function doFoo(array $one, array $two, array $three)
    {
        die;
    }
}
