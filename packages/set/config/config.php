<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\Set\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
};
