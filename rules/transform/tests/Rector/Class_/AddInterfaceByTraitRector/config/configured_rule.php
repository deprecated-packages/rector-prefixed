<?php

namespace RectorPrefix20210221;

use Rector\Transform\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Transform\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface;
use Rector\Transform\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Transform\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => [\Rector\Transform\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeTrait::class => \Rector\Transform\Tests\Rector\Class_\AddInterfaceByTraitRector\Source\SomeInterface::class]]]);
};
