<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ThisClass extends \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getThis()
    {
        return $this;
    }
}
