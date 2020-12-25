<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => ['_PhpScoper567b66d83109\\JMS\\DiExtraBundle\\Annotation\\Inject']]]);
};
