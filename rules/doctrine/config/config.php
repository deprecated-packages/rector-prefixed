<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Doctrine\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->alias(\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface::class, \Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper::class);
};
