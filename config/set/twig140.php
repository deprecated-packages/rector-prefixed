<?php

declare (strict_types=1);
namespace RectorPrefix20210124;

use RectorPrefix20210124\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210124\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/twig-underscore-to-namespace.php');
};
