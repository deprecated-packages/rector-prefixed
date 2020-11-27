<?php

namespace _PhpScoper26e51eeacccf\DeclarationWarning;

@\mkdir('/foo/bar');
require __DIR__ . '/trigger-warning.php';
class Foo
{
    public function doFoo() : void
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\DeclarationWarning\Foo
{
    public function doFoo(int $i) : void
    {
    }
}
