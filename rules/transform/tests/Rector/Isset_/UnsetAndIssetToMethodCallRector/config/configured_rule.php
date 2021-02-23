<?php

namespace RectorPrefix20210223;

use Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector;
use Rector\Transform\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer;
use Rector\Transform\ValueObject\UnsetAndIssetToMethodCall;
use RectorPrefix20210223\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210223\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\Isset_\UnsetAndIssetToMethodCallRector::ISSET_UNSET_TO_METHOD_CALL => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\UnsetAndIssetToMethodCall(\Rector\Transform\Tests\Rector\Isset_\UnsetAndIssetToMethodCallRector\Source\LocalContainer::class, 'hasService', 'removeService')])]]);
};
