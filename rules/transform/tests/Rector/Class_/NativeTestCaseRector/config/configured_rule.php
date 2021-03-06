<?php

declare (strict_types=1);
namespace RectorPrefix20210306;

use Rector\Transform\Rector\Class_\NativeTestCaseRector;
use RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210306\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Class_\NativeTestCaseRector::class);
};