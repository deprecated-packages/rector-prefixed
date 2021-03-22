<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector\Source;

final class DummyManagerRegistry
{
    public function getManager() : \Rector\Doctrine\Tests\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector\Source\DummyObjectManager
    {
        return new \Rector\Doctrine\Tests\Rector\Class_\ManagerRegistryGetManagerToEntityManagerRector\Source\DummyObjectManager();
    }
}
