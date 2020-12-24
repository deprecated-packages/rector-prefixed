<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector;
use _PhpScoperb75b35f52b74\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ContainerGetToConstructorInjectionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony\Rector\MethodCall\GetParameterToConstructorInjectionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class);
};
