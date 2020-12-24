<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => ['_PhpScopere8e811afab72\\JMS\\DiExtraBundle\\Annotation\\Inject']]]);
};
