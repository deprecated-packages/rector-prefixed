<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # both uses "%classes_to_defluent%
    $services->set(\_PhpScopere8e811afab72\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector::class);
    $configuration = [new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScopere8e811afab72\\GuzzleHttp\\json_decode', '_PhpScopere8e811afab72\\GuzzleHttp\\Utils', 'jsonDecode'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScopere8e811afab72\\GuzzleHttp\\get_path', '_PhpScopere8e811afab72\\GuzzleHttp\\Utils', 'getPath')];
    $services->set(\_PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScopere8e811afab72\\GuzzleHttp\\Utils', 'setPath', '_PhpScopere8e811afab72\\GuzzleHttp\\set_path'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScopere8e811afab72\\GuzzleHttp\\Pool', 'batch', '_PhpScopere8e811afab72\\GuzzleHttp\\Pool\\batch')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\GuzzleHttp\\Message\\MessageInterface', 'getHeaderLines', 'getHeaderAsArray')])]]);
};
