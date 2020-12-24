<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddUuidMirrorForRelationPropertyRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # add relations uuid properties
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddUuidMirrorForRelationPropertyRector::class);
};
