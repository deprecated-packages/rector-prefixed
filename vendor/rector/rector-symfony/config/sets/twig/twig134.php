<?php

declare (strict_types=1);
namespace RectorPrefix20210429;

use Rector\Symfony\Rector\Return_\SimpleFunctionAndFilterRector;
use RectorPrefix20210429\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210429\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\Return_\SimpleFunctionAndFilterRector::class);
};
