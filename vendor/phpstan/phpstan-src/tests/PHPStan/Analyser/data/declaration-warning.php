<?php

namespace _PhpScopera143bcca66cb\DeclarationWarning;

@\mkdir('/foo/bar');
require __DIR__ . '/trigger-warning.php';
class Foo
{
    public function doFoo() : void
    {
    }
}
class Bar extends \_PhpScopera143bcca66cb\DeclarationWarning\Foo
{
    public function doFoo(int $i) : void
    {
    }
}
