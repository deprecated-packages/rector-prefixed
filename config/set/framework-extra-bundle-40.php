<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Sensio\Rector\ClassMethod\RemoveServiceFromSensioRouteRector;
use Rector\Sensio\Rector\ClassMethod\ReplaceSensioRouteAnnotationWithSymfonyRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Sensio\Rector\ClassMethod\ReplaceSensioRouteAnnotationWithSymfonyRector::class);
    $services->set(\Rector\Sensio\Rector\ClassMethod\RemoveServiceFromSensioRouteRector::class);
};
