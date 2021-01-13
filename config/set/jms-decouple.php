<?php

declare (strict_types=1);
namespace RectorPrefix20210113;

use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use RectorPrefix20210113\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210113\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => ['JMS\\DiExtraBundle\\Annotation\\Inject']]]);
};
