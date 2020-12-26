<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Generic\Rector\Class_\ActionInjectionToConstructorInjectionRector;
use Rector\Generic\Rector\Variable\ReplaceVariableByPropertyFetchRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\ActionInjectionToConstructorInjectionRector::class);
    $services->set(\Rector\Generic\Rector\Variable\ReplaceVariableByPropertyFetchRector::class);
};
