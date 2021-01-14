<?php

declare (strict_types=1);
namespace RectorPrefix20210114;

use Rector\SymfonyPHPUnit\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector;
use RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\SymfonyPHPUnit\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector::class);
};
