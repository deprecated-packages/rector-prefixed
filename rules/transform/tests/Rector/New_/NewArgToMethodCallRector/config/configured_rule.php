<?php

namespace RectorPrefix20210213;

use Rector\Transform\Rector\New_\NewArgToMethodCallRector;
use Rector\Transform\Tests\Rector\New_\NewArgToMethodCallRector\Source\SomeDotenv;
use Rector\Transform\ValueObject\NewArgToMethodCall;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\New_\NewArgToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\New_\NewArgToMethodCallRector::NEW_ARGS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\NewArgToMethodCall(\Rector\Transform\Tests\Rector\New_\NewArgToMethodCallRector\Source\SomeDotenv::class, \true, 'usePutenv')])]]);
};
