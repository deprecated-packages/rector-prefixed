<?php

namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver\Source;

use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
class ParentCall extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass
{
    public function getParameters()
    {
        parent::getParameters();
    }
}
