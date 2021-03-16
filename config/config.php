<?php

declare (strict_types=1);
namespace RectorPrefix20210316;

use RectorPrefix20210316\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210316\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/services-rules.php');
    $containerConfigurator->import(__DIR__ . '/services-packages.php');
    $containerConfigurator->import(__DIR__ . '/parameters.php');
    $containerConfigurator->import(__DIR__ . '/../utils/*/config/config.php', null, \true);
};
