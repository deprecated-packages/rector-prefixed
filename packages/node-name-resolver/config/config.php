<?php

declare (strict_types=1);
namespace RectorPrefix20210121;

use RectorPrefix20210121\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210121\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeNameResolver\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Contract']);
};
