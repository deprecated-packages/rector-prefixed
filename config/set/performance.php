<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Performance\Rector\FuncCall\PreslashSimpleFunctionRector::class);
};
