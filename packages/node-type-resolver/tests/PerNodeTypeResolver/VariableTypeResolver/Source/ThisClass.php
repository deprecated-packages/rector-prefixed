<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ThisClass extends \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getThis()
    {
        return $this;
    }
}
