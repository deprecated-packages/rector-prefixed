<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony\Rector\Class_\MakeCommandLazyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony\Rector\Class_\MakeCommandLazyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector::class);
};
