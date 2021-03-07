<?php

namespace RectorPrefix20210307;

use Rector\Removing\Rector\Class_\RemoveTraitRector;
use Rector\Removing\Tests\Rector\Class_\RemoveTraitRector\Source\TraitToBeRemoved;
use RectorPrefix20210307\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210307\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Removing\Rector\Class_\RemoveTraitRector::class)->call('configure', [[\Rector\Removing\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [\Rector\Removing\Tests\Rector\Class_\RemoveTraitRector\Source\TraitToBeRemoved::class]]]);
};
