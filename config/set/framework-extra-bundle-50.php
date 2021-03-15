<?php

declare (strict_types=1);
namespace RectorPrefix20210315;

use Rector\Symfony\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use RectorPrefix20210315\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210315\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class);
};
