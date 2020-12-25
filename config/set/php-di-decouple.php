<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => ['_PhpScoper8b9c402c5f32\\DI\\Annotation\\Inject']]]);
};
