<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\Source;

trait SomeTrait
{
    public function getSomeClass() : \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\Source\SomeClass
    {
        return new \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\Source\SomeClass();
    }
}
