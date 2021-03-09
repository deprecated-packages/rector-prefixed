<?php

namespace RectorPrefix20210309;

use Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector;
use Rector\Transform\Tests\Rector\Assign\PropertyFetchToMethodCallRector\Source\Translator;
use Rector\Transform\ValueObject\PropertyFetchToMethodCall;
use RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\Assign\PropertyFetchToMethodCallRector::PROPERTIES_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\PropertyFetchToMethodCall(\Rector\Transform\Tests\Rector\Assign\PropertyFetchToMethodCallRector\Source\Translator::class, 'locale', 'getLocale', 'setLocale'), new \Rector\Transform\ValueObject\PropertyFetchToMethodCall('Rector\\Transform\\Tests\\Rector\\Assign\\PropertyFetchToMethodCallRector\\Fixture\\Fixture2', 'parameter', 'getConfig', null, ['parameter'])])]]);
};
