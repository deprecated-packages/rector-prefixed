<?php

declare (strict_types=1);
namespace RectorPrefix20210213;

use Rector\Core\Configuration\Option;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php55\Rector\String_\StringClassNameToClassConstantRector::class);
};
