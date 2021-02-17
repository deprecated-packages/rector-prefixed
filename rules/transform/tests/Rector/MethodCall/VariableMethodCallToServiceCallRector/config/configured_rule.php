<?php

declare (strict_types=1);
namespace RectorPrefix20210217;

use Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector;
use Rector\Transform\ValueObject\VariableMethodCallToServiceCall;
use RectorPrefix20210217\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210217\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $configuration = \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\VariableMethodCallToServiceCall('PhpParser\\Node', 'getAttribute', 'php_doc_info', 'Rector\\BetterPhpDocParser\\PhpDocInfo\\PhpDocInfoFactory', 'createFromNodeOrEmpty')]);
    $services->set(\Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\VariableMethodCallToServiceCallRector::VARIABLE_METHOD_CALLS_TO_SERVICE_CALLS => $configuration]]);
};
