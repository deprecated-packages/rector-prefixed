<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('Rector\\PHPStanStaticTypeMapper\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/ValueObject']);
};
