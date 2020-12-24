<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Source;

use _PhpScopere8e811afab72\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity;
class SomeEntityProvider
{
    /**
     * @return SomeEntity[]
     */
    public function provide() : array
    {
        return [new \_PhpScopere8e811afab72\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity()];
    }
}
