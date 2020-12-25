<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2;

use Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Sensio\Rector\ClassMethod\TemplateAnnotationToThisRenderRector::class);
};
