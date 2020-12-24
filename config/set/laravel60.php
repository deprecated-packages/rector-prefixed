<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see https://laravel.com/docs/6.x/upgrade
# https://github.com/laravel/docs/pull/5531/files
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\MethodCallToReturn('_PhpScoperb75b35f52b74\\Illuminate\\Auth\\Access\\HandlesAuthorization', 'deny')])]]);
    # https://github.com/laravel/framework/commit/67a38ba0fa2acfbd1f4af4bf7d462bb4419cc091
    $services->set(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScoperb75b35f52b74\\Illuminate\\Auth\\Access\\Gate',
        # https://github.com/laravel/framework/commit/69de466ddc25966a0f6551f48acab1afa7bb9424
        'access',
        'inspect'
    ), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Lang',
        # https://github.com/laravel/framework/commit/efbe23c4116f86846ad6edc0d95cd56f4175a446
        'trans',
        'get'
    ), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Lang', 'transChoice', 'choice'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScoperb75b35f52b74\\Illuminate\\Translation\\Translator',
        # https://github.com/laravel/framework/commit/697b898a1c89881c91af83ecc4493fa681e2aa38
        'getFromJson',
        'get'
    )])]]);
    $configuration = [
        # https://github.com/laravel/framework/commit/55785d3514a8149d4858acef40c56a31b6b2ccd1
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod('_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Input', 'get', '_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Request', 'input'),
    ];
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Input' => '_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Request']]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Illuminate\\Foundation\\Http\\FormRequest', 'validationData', 'public')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/laravel/framework/commit/6c1e014943a508afb2c10869c3175f7783a004e1
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Database\\Capsule\\Manager', 'table', 1, 'as', 'null'),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Database\\Connection', 'table', 1, 'as', 'null'),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Database\\ConnectionInterface', 'table', 1, 'as', 'null'),
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperb75b35f52b74\\Illuminate\\Database\\Query\\Builder', 'from', 1, 'as', 'null'),
    ])]]);
};
