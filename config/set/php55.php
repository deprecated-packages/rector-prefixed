<?php

declare (strict_types=1);
namespace RectorPrefix20210126;

use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use RectorPrefix20210126\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210126\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);
};
