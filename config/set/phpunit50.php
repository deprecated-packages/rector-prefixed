<?php

declare (strict_types=1);
namespace RectorPrefix20210129;

use Rector\PHPUnit\Rector\StaticCall\GetMockRector;
use RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210129\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPUnit\Rector\StaticCall\GetMockRector::class);
};
