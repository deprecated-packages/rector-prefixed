<?php

declare (strict_types=1);
namespace RectorPrefix20210206;

use Rector\Sensio\Rector\ClassMethod\RemoveServiceFromSensioRouteRector;
use Rector\Sensio\Rector\ClassMethod\ReplaceSensioRouteAnnotationWithSymfonyRector;
use RectorPrefix20210206\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210206\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Sensio\Rector\ClassMethod\ReplaceSensioRouteAnnotationWithSymfonyRector::class);
    $services->set(\Rector\Sensio\Rector\ClassMethod\RemoveServiceFromSensioRouteRector::class);
};
