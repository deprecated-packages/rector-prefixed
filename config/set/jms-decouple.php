<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => ['_PhpScoperbf340cb0be9d\\JMS\\DiExtraBundle\\Annotation\\Inject']]]);
};
