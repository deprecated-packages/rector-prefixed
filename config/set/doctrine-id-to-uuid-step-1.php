<?php

declare (strict_types=1);
namespace RectorPrefix20210221;

use Rector\Doctrine\Rector\Class_\AddUuidToEntityWhereMissingRector;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # add uuid id property
    $services->set(\Rector\Doctrine\Rector\Class_\AddUuidToEntityWhereMissingRector::class);
};
