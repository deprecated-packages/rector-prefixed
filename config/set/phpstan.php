<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector;
use Rector\PHPStan\Rector\Cast\RecastingRemovalRector;
use Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPStan\Rector\Cast\RecastingRemovalRector::class);
    $services->set(\Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector::class);
    $services->set(\Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector::class);
};
