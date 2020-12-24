<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector;
use _PhpScopere8e811afab72\Rector\PHPStan\Rector\Cast\RecastingRemovalRector;
use _PhpScopere8e811afab72\Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\PHPStan\Rector\Cast\RecastingRemovalRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector::class);
};
