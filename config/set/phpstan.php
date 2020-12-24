<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Rector\Cast\RecastingRemovalRector;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPStan\Rector\Cast\RecastingRemovalRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPStan\Rector\Assign\PHPStormVarAnnotationRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PHPStan\Rector\Node\RemoveNonExistingVarAnnotationRector::class);
};
