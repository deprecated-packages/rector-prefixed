<?php

declare (strict_types=1);
namespace RectorPrefix20210228;

use Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall;
use Rector\Transform\ValueObject\ArrayFuncCallToMethodCall;
use RectorPrefix20210228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::FUNCTIONS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('view', 'Illuminate\\Contracts\\View\\Factory', 'make'), new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('route', 'Illuminate\\Routing\\UrlGenerator', 'route'), new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('back', 'Illuminate\\Routing\\Redirector', 'back', 'back'), new \Rector\Transform\ValueObject\ArgumentFuncCallToMethodCall('broadcast', 'Illuminate\\Contracts\\Broadcasting\\Factory', 'event')]), \Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector::ARRAY_FUNCTIONS_TO_METHOD_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('config', 'Illuminate\\Contracts\\Config\\Repository', 'set', 'get'), new \Rector\Transform\ValueObject\ArrayFuncCallToMethodCall('session', 'Illuminate\\Session\\SessionManager', 'put', 'get')])]]);
};
