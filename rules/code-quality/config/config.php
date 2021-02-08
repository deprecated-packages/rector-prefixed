<?php

declare (strict_types=1);
namespace RectorPrefix20210208;

use RectorPrefix20210208\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210208\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\CodeQuality\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
};
