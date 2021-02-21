<?php

namespace RectorPrefix20210221;

use Rector\Transform\Rector\Assign\GetAndSetToMethodCallRector;
use Rector\Transform\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka;
use Rector\Transform\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Assign\GetAndSetToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\Assign\GetAndSetToMethodCallRector::TYPE_TO_METHOD_CALLS => [\Rector\Transform\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\SomeContainer::class => ['get' => 'getService', 'set' => 'addService'], \Rector\Transform\Tests\Rector\Assign\GetAndSetToMethodCallRector\Source\Klarka::class => ['get' => 'get']]]]);
};
