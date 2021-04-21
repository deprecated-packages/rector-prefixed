<?php

declare(strict_types=1);

use Rector\Symfony\Rector\Attribute\ExtractAttributeRouteNameConstantsRector;
use Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector;
use Rector\Symfony\Rector\Class_\EventListenerToEventSubscriberRector;
use Rector\Symfony\Rector\Class_\MakeCommandLazyRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();
    $services->set(ResponseStatusCodeRector::class);
    $services->set(MakeCommandLazyRector::class);
    $services->set(EventListenerToEventSubscriberRector::class);
    $services->set(ExtractAttributeRouteNameConstantsRector::class);
};
