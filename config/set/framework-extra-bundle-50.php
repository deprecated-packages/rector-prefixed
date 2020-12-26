<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class);
};
