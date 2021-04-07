<?php

declare (strict_types=1);
namespace RectorPrefix20210407;

use Rector\Laravel\Rector\Assign\CallOnAppArrayAccessToStandaloneAssignRector;
use RectorPrefix20210407\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210407\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Laravel\Rector\Assign\CallOnAppArrayAccessToStandaloneAssignRector::class);
};
