<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ThisClass extends \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getThis()
    {
        return $this;
    }
}
