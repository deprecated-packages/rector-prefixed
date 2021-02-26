<?php

namespace RectorPrefix20210226;

use Rector\CodingStyle\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector;
use Rector\CodingStyle\Tests\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector\Source\EventSubscriberInterface;
use RectorPrefix20210226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector::class)->call('configure', [[\Rector\CodingStyle\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector::METHODS_BY_TYPE => [\Rector\CodingStyle\Tests\Rector\ClassMethod\YieldClassMethodToArrayClassMethodRector\Source\EventSubscriberInterface::class => ['getSubscribedEvents']]]]);
};
