<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ThisClass extends \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getThis()
    {
        return $this;
    }
}
