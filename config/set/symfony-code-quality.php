<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector;
use _PhpScopere8e811afab72\Rector\Symfony\Rector\Class_\MakeCommandLazyRector;
use _PhpScopere8e811afab72\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony\Rector\Class_\MakeCommandLazyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector::class);
};
