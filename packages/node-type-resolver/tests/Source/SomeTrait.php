<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source;

trait SomeTrait
{
    public function getSomeClass() : \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\SomeClass
    {
        return new \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\SomeClass();
    }
}
