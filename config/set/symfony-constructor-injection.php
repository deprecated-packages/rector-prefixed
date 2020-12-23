<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector;
use _PhpScoper0a2ac50786fa\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use _PhpScoper0a2ac50786fa\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class);
};
