<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Source;

use _PhpScoperb75b35f52b74\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity;
class SomeEntityProvider
{
    /**
     * @return SomeEntity[]
     */
    public function provide() : array
    {
        return [new \_PhpScoperb75b35f52b74\Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedDoctrineEntityMethodAndPropertyRector\Fixture\SomeEntity()];
    }
}
