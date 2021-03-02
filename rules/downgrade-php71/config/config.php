<?php

declare (strict_types=1);
namespace RectorPrefix20210302;

use RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\DowngradePhp71\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
};