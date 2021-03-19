<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Laravel\Rector\Class_\PropertyDeferToDeferrableProviderToRector::class);
};
