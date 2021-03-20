<?php

declare (strict_types=1);
namespace RectorPrefix20210320;

use Rector\Symfony2\Rector\MethodCall\AddFlashRector;
use RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony2\Rector\MethodCall\AddFlashRector::class);
};
