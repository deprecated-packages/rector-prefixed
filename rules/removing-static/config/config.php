<?php

declare (strict_types=1);
namespace RectorPrefix20210130;

use Rector\Core\Configuration\Option;
use RectorPrefix20210130\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210130\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::TYPES_TO_REMOVE_STATIC_FROM, []);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\RemovingStatic\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
};
