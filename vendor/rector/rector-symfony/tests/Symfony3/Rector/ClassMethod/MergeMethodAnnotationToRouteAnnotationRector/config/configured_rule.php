<?php

declare (strict_types=1);
namespace RectorPrefix20210318;

use Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector::class);
};
