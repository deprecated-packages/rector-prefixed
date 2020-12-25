<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Laravel\Rector\Assign\CallOnAppArrayAccessToStandaloneAssignRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Laravel\Rector\Assign\CallOnAppArrayAccessToStandaloneAssignRector::class);
};
