<?php

declare (strict_types=1);
namespace RectorPrefix20210129;

use Rector\Twig\Rector\Return_\SimpleFunctionAndFilterRector;
use RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Twig\Rector\Return_\SimpleFunctionAndFilterRector::class);
};
