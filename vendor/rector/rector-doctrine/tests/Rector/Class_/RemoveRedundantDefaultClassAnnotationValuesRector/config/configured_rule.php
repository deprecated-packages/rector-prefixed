<?php

declare (strict_types=1);
namespace RectorPrefix20210322;

use Rector\Doctrine\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector;
use RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Doctrine\Rector\Class_\RemoveRedundantDefaultClassAnnotationValuesRector::class);
};
