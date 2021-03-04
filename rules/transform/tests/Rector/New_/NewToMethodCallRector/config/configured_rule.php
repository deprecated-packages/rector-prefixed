<?php

namespace RectorPrefix20210304;

use Rector\Transform\Rector\New_\NewToMethodCallRector;
use Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClass;
use Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClassFactory;
use Rector\Transform\ValueObject\NewToMethodCall;
use RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\New_\NewToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\New_\NewToMethodCallRector::NEWS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\NewToMethodCall(\Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClass::class, \Rector\Transform\Tests\Rector\New_\NewToMethodCallRector\Source\MyClassFactory::class, 'create')])]]);
};
