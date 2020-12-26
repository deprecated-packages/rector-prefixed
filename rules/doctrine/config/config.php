<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Doctrine\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->alias(\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface::class, \Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper::class);
};
