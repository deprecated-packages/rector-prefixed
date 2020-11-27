<?php

namespace _PhpScoper006a73f0e455\DeclarationWarning;

@\mkdir('/foo/bar');
require __DIR__ . '/trigger-warning.php';
class Foo
{
    public function doFoo() : void
    {
    }
}
class Bar extends \_PhpScoper006a73f0e455\DeclarationWarning\Foo
{
    public function doFoo(int $i) : void
    {
    }
}
