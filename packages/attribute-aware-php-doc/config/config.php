<?php

declare (strict_types=1);
namespace RectorPrefix20210216;

use RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\AttributeAwarePhpDoc\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Ast']);
};
