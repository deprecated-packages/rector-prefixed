<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21;

use Rector\Doctrine\Rector\Class_\AddUuidToEntityWhereMissingRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # add uuid id property
    $services->set(\Rector\Doctrine\Rector\Class_\AddUuidToEntityWhereMissingRector::class);
};
