<?php

declare (strict_types=1);
namespace RectorPrefix20210221;

use Rector\CodingStyle\Rector\FuncCall\PreslashSimpleFunctionRector;
use Rector\Core\Configuration\Option;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodingStyle\Rector\FuncCall\PreslashSimpleFunctionRector::class);
};
