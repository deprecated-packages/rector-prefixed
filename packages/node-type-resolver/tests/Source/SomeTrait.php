<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source;

trait SomeTrait
{
    public function getSomeClass() : \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\SomeClass
    {
        return new \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\SomeClass();
    }
}
