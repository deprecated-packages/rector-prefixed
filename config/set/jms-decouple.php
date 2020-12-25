<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2;

use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => ['_PhpScoper5edc98a7cce2\\JMS\\DiExtraBundle\\Annotation\\Inject']]]);
};
