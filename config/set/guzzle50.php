<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21;

use Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use Rector\Transform\ValueObject\FuncNameToMethodCallName;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # both uses "%classes_to_defluent%
    $services->set(\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector::class);
    $configuration = [new \Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\json_decode', '_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\Utils', 'jsonDecode'), new \Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\get_path', '_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\Utils', 'getPath')];
    $services->set(\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class)->call('configure', [[\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class)->call('configure', [[\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\Utils', 'setPath', '_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\set_path'), new \Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\Pool', 'batch', '_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\Pool\\batch')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5b8c9e9ebd21\\GuzzleHttp\\Message\\MessageInterface', 'getHeaderLines', 'getHeaderAsArray')])]]);
};
