<?php

namespace _PhpScoper88fe6e0ad041\CompactVariables;

class Foo
{
    /**
     * @return string[]
     */
    public function doFoo(string $foo) : array
    {
        $methodFoo = 'foo';
        $methodBar = 'bar';
        if ($foo === 'defined') {
            $baz = 'maybe defined';
        }
        return \compact($foo, $methodFoo, $methodBar, 'baz');
    }
}
