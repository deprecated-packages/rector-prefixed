<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use Rector\Symfony\Rector\Class_\MakeCommandLazyRector;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\Class_\MakeCommandLazyRector::class);
};
