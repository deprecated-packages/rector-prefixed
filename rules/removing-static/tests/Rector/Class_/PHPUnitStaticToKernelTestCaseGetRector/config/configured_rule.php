<?php

namespace RectorPrefix20210304;

use Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector;
use Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source\ClassWithStaticMethods;
use RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector::class)->call('configure', [[\Rector\RemovingStatic\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector::STATIC_CLASS_TYPES => [\Rector\RemovingStatic\Tests\Rector\Class_\PHPUnitStaticToKernelTestCaseGetRector\Source\ClassWithStaticMethods::class]]]);
};
