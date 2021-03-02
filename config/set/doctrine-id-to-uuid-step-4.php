<?php

declare (strict_types=1);
namespace RectorPrefix20210302;

use Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector;
use Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector;
use Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector;
use Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector;
use Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector;
use RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # properties
    $services->set(\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector::class);
    $services->set(\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector::class);
    $services->set(\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector::class);
    # methods
    $services->set(\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector::class);
    $services->set(\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector::class);
};
