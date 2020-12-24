<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector;
use _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # properties
    $services->set(\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Property\AddUuidAnnotationsToIdPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidColumnPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Property\RemoveTemporaryUuidRelationPropertyRector::class);
    # methods
    $services->set(\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\ClassMethod\ChangeGetIdTypeToUuidRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\ClassMethod\ChangeSetIdTypeToUuidRector::class);
};
