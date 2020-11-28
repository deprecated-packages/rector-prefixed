<?php

namespace _PhpScoperabd03f0baf05\DeclarationWarning;

@\mkdir('/foo/bar');
require __DIR__ . '/trigger-warning.php';
class Foo
{
    public function doFoo() : void
    {
    }
}
class Bar extends \_PhpScoperabd03f0baf05\DeclarationWarning\Foo
{
    public function doFoo(int $i) : void
    {
    }
}
