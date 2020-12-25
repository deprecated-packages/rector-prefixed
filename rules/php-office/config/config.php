<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->load('Rector\\PHPOffice\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Rector', __DIR__ . '/../src/ValueObject']);
};
