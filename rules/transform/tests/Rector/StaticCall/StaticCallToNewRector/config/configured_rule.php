<?php

namespace RectorPrefix20210302;

use Rector\Transform\Rector\StaticCall\StaticCallToNewRector;
use Rector\Transform\Tests\Rector\StaticCall\StaticCallToNewRector\Source\SomeJsonResponse;
use Rector\Transform\ValueObject\StaticCallToNew;
use RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210302\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\StaticCall\StaticCallToNewRector::class)->call('configure', [[\Rector\Transform\Rector\StaticCall\StaticCallToNewRector::STATIC_CALLS_TO_NEWS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\StaticCallToNew(\Rector\Transform\Tests\Rector\StaticCall\StaticCallToNewRector\Source\SomeJsonResponse::class, 'create')])]]);
};
