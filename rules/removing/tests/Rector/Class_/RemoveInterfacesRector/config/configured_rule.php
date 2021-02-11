<?php

namespace RectorPrefix20210211;

use Rector\Removing\Rector\Class_\RemoveInterfacesRector;
use Rector\Removing\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface;
use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Removing\Rector\Class_\RemoveInterfacesRector::class)->call('configure', [[\Rector\Removing\Rector\Class_\RemoveInterfacesRector::INTERFACES_TO_REMOVE => [\Rector\Removing\Tests\Rector\Class_\RemoveInterfacesRector\Source\SomeInterface::class]]]);
};
