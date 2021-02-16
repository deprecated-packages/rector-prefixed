<?php

namespace RectorPrefix20210216;

use Rector\Removing\Rector\Class_\RemoveParentRector;
use Rector\Removing\Tests\Rector\Class_\RemoveParentRector\Source\ParentTypeToBeRemoved;
use RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210216\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Removing\Rector\Class_\RemoveParentRector::class)->call('configure', [[\Rector\Removing\Rector\Class_\RemoveParentRector::PARENT_TYPES_TO_REMOVE => [\Rector\Removing\Tests\Rector\Class_\RemoveParentRector\Source\ParentTypeToBeRemoved::class]]]);
};
