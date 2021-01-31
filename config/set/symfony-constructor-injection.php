<?php

declare (strict_types=1);
namespace RectorPrefix20210131;

use Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector;
use Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use RectorPrefix20210131\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210131\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class);
};
