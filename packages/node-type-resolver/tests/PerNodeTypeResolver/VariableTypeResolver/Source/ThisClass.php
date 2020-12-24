<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source;

use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ThisClass extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getThis()
    {
        return $this;
    }
}
