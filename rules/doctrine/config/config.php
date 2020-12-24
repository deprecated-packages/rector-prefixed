<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Doctrine\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
    $services->alias(\_PhpScoper0a6b37af0871\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface::class, \_PhpScoper0a6b37af0871\Rector\Doctrine\Mapper\DefaultDoctrineEntityAndRepositoryMapper::class);
};
