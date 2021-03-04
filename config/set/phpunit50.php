<?php

declare (strict_types=1);
namespace RectorPrefix20210304;

use Rector\PHPUnit\Rector\StaticCall\GetMockRector;
use RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPUnit\Rector\StaticCall\GetMockRector::class);
};
