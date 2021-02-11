<?php

declare (strict_types=1);
namespace RectorPrefix20210211;

use Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector;
use Rector\Symfony\Rector\Class_\MakeCommandLazyRector;
use Rector\SymfonyCodeQuality\Rector\Attribute\ExtractAttributeRouteNameConstantsRector;
use Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector::class);
    $services->set(\Rector\Symfony\Rector\Class_\MakeCommandLazyRector::class);
    $services->set(\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector::class);
    $services->set(\Rector\SymfonyCodeQuality\Rector\Attribute\ExtractAttributeRouteNameConstantsRector::class);
};
