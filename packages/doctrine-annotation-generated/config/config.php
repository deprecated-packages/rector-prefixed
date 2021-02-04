<?php

declare (strict_types=1);
namespace RectorPrefix20210204;

use RectorPrefix20210204\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210204\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\DoctrineAnnotationGenerated\\', __DIR__ . '/../src');
};
