<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\DependencyInjection\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
};
