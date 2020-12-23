<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # both uses "%classes_to_defluent%
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector::class);
    $configuration = [new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper0a2ac50786fa\\GuzzleHttp\\json_decode', '_PhpScoper0a2ac50786fa\\GuzzleHttp\\Utils', 'jsonDecode'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper0a2ac50786fa\\GuzzleHttp\\get_path', '_PhpScoper0a2ac50786fa\\GuzzleHttp\\Utils', 'getPath')];
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper0a2ac50786fa\\GuzzleHttp\\Utils', 'setPath', '_PhpScoper0a2ac50786fa\\GuzzleHttp\\set_path'), new \_PhpScoper0a2ac50786fa\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper0a2ac50786fa\\GuzzleHttp\\Pool', 'batch', '_PhpScoper0a2ac50786fa\\GuzzleHttp\\Pool\\batch')])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\GuzzleHttp\\Message\\MessageInterface', 'getHeaderLines', 'getHeaderAsArray')])]]);
};
