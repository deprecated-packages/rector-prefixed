<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncNameToMethodCallName;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # both uses "%classes_to_defluent%
    $services->set(\_PhpScoperb75b35f52b74\Rector\Defluent\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector::class);
    $configuration = [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoperb75b35f52b74\\GuzzleHttp\\json_decode', '_PhpScoperb75b35f52b74\\GuzzleHttp\\Utils', 'jsonDecode'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\FuncNameToMethodCallName('_PhpScoperb75b35f52b74\\GuzzleHttp\\get_path', '_PhpScoperb75b35f52b74\\GuzzleHttp\\Utils', 'getPath')];
    $services->set(\_PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Transform\Rector\FuncCall\FuncCallToMethodCallRector::FUNC_CALL_TO_CLASS_METHOD_CALL => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall\StaticCallToFuncCallRector::STATIC_CALLS_TO_FUNCTIONS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoperb75b35f52b74\\GuzzleHttp\\Utils', 'setPath', '_PhpScoperb75b35f52b74\\GuzzleHttp\\set_path'), new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToFuncCall('_PhpScoperb75b35f52b74\\GuzzleHttp\\Pool', 'batch', '_PhpScoperb75b35f52b74\\GuzzleHttp\\Pool\\batch')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\GuzzleHttp\\Message\\MessageInterface', 'getHeaderLines', 'getHeaderAsArray')])]]);
};
