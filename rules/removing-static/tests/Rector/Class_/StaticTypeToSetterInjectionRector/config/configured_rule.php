<?php

namespace RectorPrefix20210304;

use Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector;
use Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactory;
use Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactoryWithInterface;
use RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector::class)->call('configure', [[\Rector\RemovingStatic\Rector\Class_\StaticTypeToSetterInjectionRector::STATIC_TYPES => [
        \Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactory::class,
        // with adding a parent interface to the class
        'ParentSetterEnforcingInterface' => \Rector\RemovingStatic\Tests\Rector\Class_\StaticTypeToSetterInjectionRector\Source\GenericEntityFactoryWithInterface::class,
    ]]]);
};
