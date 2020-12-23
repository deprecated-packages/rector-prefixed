<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Rector\Cast\RecastingRemovalRector;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPStan\Rector\Cast\RecastingRemovalRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector::class);
};
