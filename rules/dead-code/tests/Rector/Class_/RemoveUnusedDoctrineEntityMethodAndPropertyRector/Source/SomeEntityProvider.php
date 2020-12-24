<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Source;

use _PhpScoper2a4e7ab1ecbc\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity;
class SomeEntityProvider
{
    /**
     * @return SomeEntity[]
     */
    public function provide() : array
    {
        return [new \_PhpScoper2a4e7ab1ecbc\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity()];
    }
}
