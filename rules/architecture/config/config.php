<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->public()->autoconfigure();
    $services->load('Rector\\Architecture\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector']);
};
