<?php

declare (strict_types=1);
namespace RectorPrefix20210211;

use Rector\Transform\Tests\Rector\Class_\CommunityTestCaseRector\Fixture\SomeRector;
use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Tests\Rector\Class_\CommunityTestCaseRector\Fixture\SomeRector::class);
};