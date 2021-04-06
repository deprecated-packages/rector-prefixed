<?php

declare (strict_types=1);
namespace RectorPrefix20210406;

use RectorPrefix20210406\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210406\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/included-config.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set('two', 2);
};
