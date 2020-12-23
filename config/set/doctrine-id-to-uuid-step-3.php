<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Class_\AddUuidMirrorForRelationPropertyRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # add relations uuid properties
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Class_\AddUuidMirrorForRelationPropertyRector::class);
};
