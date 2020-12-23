<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector;
use _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector;
use _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector;
use _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector;
use _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # properties
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector::class);
    # methods
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector::class);
};
