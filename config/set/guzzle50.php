<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # both uses "%classes_to_defluent%
    $services->set(\_PhpScoper0a6b37af0871\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector::class);
    $configuration = [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper0a6b37af0871\\GuzzleHttp\\json_decode', '_PhpScoper0a6b37af0871\\GuzzleHttp\\Utils', 'jsonDecode'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper0a6b37af0871\\GuzzleHttp\\get_path', '_PhpScoper0a6b37af0871\\GuzzleHttp\\Utils', 'getPath')];
    $services->set(\_PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper0a6b37af0871\\GuzzleHttp\\Utils', 'setPath', '_PhpScoper0a6b37af0871\\GuzzleHttp\\set_path'), new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper0a6b37af0871\\GuzzleHttp\\Pool', 'batch', '_PhpScoper0a6b37af0871\\GuzzleHttp\\Pool\\batch')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\GuzzleHttp\\Message\\MessageInterface', 'getHeaderLines', 'getHeaderAsArray')])]]);
};
