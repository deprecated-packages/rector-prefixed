<?php

namespace RectorPrefix20210225;

use Rector\Transform\Rector\Class_\MergeInterfacesRector;
use Rector\Transform\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface;
use Rector\Transform\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface;
use RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Class_\MergeInterfacesRector::class)->call('configure', [[\Rector\Transform\Rector\Class_\MergeInterfacesRector::OLD_TO_NEW_INTERFACES => [\Rector\Transform\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface::class => \Rector\Transform\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface::class]]]);
};
