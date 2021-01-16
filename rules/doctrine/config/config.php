<?php

declare (strict_types=1);
namespace RectorPrefix20210116;

use Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper;
use RectorPrefix20210116\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210116\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Doctrine\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->alias(\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface::class, \Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper::class);
};
