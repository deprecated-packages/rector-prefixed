<?php

declare (strict_types=1);
namespace RectorPrefix20210508;

use Rector\NetteToSymfony\Rector\ClassMethod\RouterListToControllerAnnotationsRector;
use RectorPrefix20210508\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210508\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteToSymfony\Rector\ClassMethod\RouterListToControllerAnnotationsRector::class);
};
