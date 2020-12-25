<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\CodeQuality\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
};
