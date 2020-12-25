<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector;
use Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class);
};
