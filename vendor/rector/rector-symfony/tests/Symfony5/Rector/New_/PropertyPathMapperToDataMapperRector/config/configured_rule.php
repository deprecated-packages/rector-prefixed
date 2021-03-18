<?php

declare (strict_types=1);
namespace RectorPrefix20210318;

use Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector;
use RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210318\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony5\Rector\New_\PropertyPathMapperToDataMapperRector::class);
};
