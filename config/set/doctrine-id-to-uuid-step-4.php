<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # properties
    $services->set(\_PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector::class);
    # methods
    $services->set(\_PhpScoper0a6b37af0871\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector::class);
};
