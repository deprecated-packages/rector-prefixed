<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector;
use Rector\MockistaToMockery\Rector\ClassMethod\MockistaMockToMockeryMockRector;
use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector::class);
    $services->set(\Rector\MockistaToMockery\Rector\ClassMethod\MockistaMockToMockeryMockRector::class);
};
