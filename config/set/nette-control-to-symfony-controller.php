<?php

declare (strict_types=1);
namespace RectorPrefix20210317;

use Rector\NetteToSymfony\Rector\Class_\NetteControlToSymfonyControllerRector;
use RectorPrefix20210317\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210317\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\Class_\NetteControlToSymfonyControllerRector::class);
};
