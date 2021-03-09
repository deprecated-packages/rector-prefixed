<?php

declare (strict_types=1);
namespace RectorPrefix20210309;

use Rector\Transform\Tests\Rector\Class_\NativeTestCaseRector\Fixture\SomeRector;
use RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Tests\Rector\Class_\NativeTestCaseRector\Fixture\SomeRector::class);
};
