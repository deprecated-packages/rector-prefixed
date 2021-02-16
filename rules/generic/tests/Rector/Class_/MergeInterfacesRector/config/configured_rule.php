<?php

namespace RectorPrefix20210216;

use Rector\Generic\Rector\Class_\MergeInterfacesRector;
use Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface;
use Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface;
use RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\MergeInterfacesRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\MergeInterfacesRector::OLD_TO_NEW_INTERFACES => [\Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeOldInterface::class => \Rector\Generic\Tests\Rector\Class_\MergeInterfacesRector\Source\SomeInterface::class]]]);
};
