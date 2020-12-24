<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # both uses "%classes_to_defluent%
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector::class);
    $configuration = [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\json_decode', '_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\Utils', 'jsonDecode'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\get_path', '_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\Utils', 'getPath')];
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\Utils', 'setPath', '_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\set_path'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\Pool', 'batch', '_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\Pool\\batch')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\GuzzleHttp\\Message\\MessageInterface', 'getHeaderLines', 'getHeaderAsArray')])]]);
};
