<?php

declare (strict_types=1);
namespace RectorPrefix20210407;

use RectorPrefix20210407\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210407\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('key', 'value');
    $parameters->set('camelCase', 'Lion');
    $parameters->set('pascal_case', 'Celsius');
};
