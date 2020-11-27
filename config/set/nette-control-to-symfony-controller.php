<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use Rector\NetteToSymfony\Rector\Class_\NetteControlToSymfonyControllerRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\Class_\NetteControlToSymfonyControllerRector::class);
};
