<?php

namespace _PhpScoper88fe6e0ad041\DeclarationWarning;

@\mkdir('/foo/bar');
require __DIR__ . '/trigger-warning.php';
class Foo
{
    public function doFoo() : void
    {
    }
}
class Bar extends \_PhpScoper88fe6e0ad041\DeclarationWarning\Foo
{
    public function doFoo(int $i) : void
    {
    }
}