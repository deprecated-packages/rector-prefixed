<?php

declare (strict_types=1);
namespace RectorPrefix20210127;

use RectorPrefix20210127\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210127\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\NodeCollector\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
};
