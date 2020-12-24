<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector;
use _PhpScoper0a6b37af0871\Rector\Symfony\Rector\Class_\MakeCommandLazyRector;
use _PhpScoper0a6b37af0871\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony\Rector\Class_\MakeCommandLazyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector::class);
};
