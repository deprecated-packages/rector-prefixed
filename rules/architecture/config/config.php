<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Architecture\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
};
