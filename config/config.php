<?php

declare (strict_types=1);
namespace RectorPrefix20210315;

use RectorPrefix20210315\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210315\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    // @todo this should be removed
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/services-rules.php');
    $containerConfigurator->import(__DIR__ . '/parameters.php');
    $containerConfigurator->import(__DIR__ . '/../utils/*/config/config.php', null, \true);
};
