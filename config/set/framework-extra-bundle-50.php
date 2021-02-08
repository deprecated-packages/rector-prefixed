<?php

declare (strict_types=1);
namespace RectorPrefix20210208;

use Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use RectorPrefix20210208\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210208\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class);
};
