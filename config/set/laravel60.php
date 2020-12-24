<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\MethodCallToReturn;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see https://laravel.com/docs/6.x/upgrade
# https://github.com/laravel/docs/pull/5531/files
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\MethodCallToReturn('_PhpScopere8e811afab72\\Illuminate\\Auth\\Access\\HandlesAuthorization', 'deny')])]]);
    # https://github.com/laravel/framework/commit/67a38ba0fa2acfbd1f4af4bf7d462bb4419cc091
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScopere8e811afab72\\Illuminate\\Auth\\Access\\Gate',
        # https://github.com/laravel/framework/commit/69de466ddc25966a0f6551f48acab1afa7bb9424
        'access',
        'inspect'
    ), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Lang',
        # https://github.com/laravel/framework/commit/efbe23c4116f86846ad6edc0d95cd56f4175a446
        'trans',
        'get'
    ), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Lang', 'transChoice', 'choice'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScopere8e811afab72\\Illuminate\\Translation\\Translator',
        # https://github.com/laravel/framework/commit/697b898a1c89881c91af83ecc4493fa681e2aa38
        'getFromJson',
        'get'
    )])]]);
    $configuration = [
        # https://github.com/laravel/framework/commit/55785d3514a8149d4858acef40c56a31b6b2ccd1
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameStaticMethod('_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Input', 'get', '_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Request', 'input'),
    ];
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Input' => '_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Request']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Illuminate\\Foundation\\Http\\FormRequest', 'validationData', 'public')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/laravel/framework/commit/6c1e014943a508afb2c10869c3175f7783a004e1
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Database\\Capsule\\Manager', 'table', 1, 'as', 'null'),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Database\\Connection', 'table', 1, 'as', 'null'),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Database\\ConnectionInterface', 'table', 1, 'as', 'null'),
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Illuminate\\Database\\Query\\Builder', 'from', 1, 'as', 'null'),
    ])]]);
};
