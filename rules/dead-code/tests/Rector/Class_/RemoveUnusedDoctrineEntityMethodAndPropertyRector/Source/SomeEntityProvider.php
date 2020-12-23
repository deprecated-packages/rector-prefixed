<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Source;

use _PhpScoper0a2ac50786fa\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity;
class SomeEntityProvider
{
    /**
     * @return SomeEntity[]
     */
    public function provide() : array
    {
        return [new \_PhpScoper0a2ac50786fa\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity()];
    }
}
