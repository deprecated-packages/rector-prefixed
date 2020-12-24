<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source;

trait SomeTrait
{
    public function getSomeClass() : \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\SomeClass
    {
        return new \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\SomeClass();
    }
}
