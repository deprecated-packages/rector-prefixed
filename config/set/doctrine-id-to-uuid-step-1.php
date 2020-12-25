<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Doctrine\Rector\Class_\AddUuidToEntityWhereMissingRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # add uuid id property
    $services->set(\Rector\Doctrine\Rector\Class_\AddUuidToEntityWhereMissingRector::class);
};
