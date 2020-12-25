<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2;

use Rector\Core\ValueObject\Visibility;
use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Generic\Rector\Expression\MethodCallToReturnRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Generic\ValueObject\ChangeMethodVisibility;
use Rector\Generic\ValueObject\MethodCallToReturn;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameStaticMethod;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see https://laravel.com/docs/6.x/upgrade
# https://github.com/laravel/docs/pull/5531/files
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Expression\MethodCallToReturnRector::class)->call('configure', [[\Rector\Generic\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\MethodCallToReturn('_PhpScoper5edc98a7cce2\\Illuminate\\Auth\\Access\\HandlesAuthorization', 'deny')])]]);
    # https://github.com/laravel/framework/commit/67a38ba0fa2acfbd1f4af4bf7d462bb4419cc091
    $services->set(\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScoper5edc98a7cce2\\Illuminate\\Auth\\Access\\Gate',
        # https://github.com/laravel/framework/commit/69de466ddc25966a0f6551f48acab1afa7bb9424
        'access',
        'inspect'
    ), new \Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Lang',
        # https://github.com/laravel/framework/commit/efbe23c4116f86846ad6edc0d95cd56f4175a446
        'trans',
        'get'
    ), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Lang', 'transChoice', 'choice'), new \Rector\Renaming\ValueObject\MethodCallRename(
        '_PhpScoper5edc98a7cce2\\Illuminate\\Translation\\Translator',
        # https://github.com/laravel/framework/commit/697b898a1c89881c91af83ecc4493fa681e2aa38
        'getFromJson',
        'get'
    )])]]);
    $configuration = [
        # https://github.com/laravel/framework/commit/55785d3514a8149d4858acef40c56a31b6b2ccd1
        new \Rector\Renaming\ValueObject\RenameStaticMethod('_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Input', 'get', '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Request', 'input'),
    ];
    $services->set(\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($configuration)]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Input' => '_PhpScoper5edc98a7cce2\\Illuminate\\Support\\Facades\\Request']]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper5edc98a7cce2\\Illuminate\\Foundation\\Http\\FormRequest', 'validationData', \Rector\Core\ValueObject\Visibility::PUBLIC)])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/laravel/framework/commit/6c1e014943a508afb2c10869c3175f7783a004e1
        new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper5edc98a7cce2\\Illuminate\\Database\\Capsule\\Manager', 'table', 1, 'as', 'null'),
        new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper5edc98a7cce2\\Illuminate\\Database\\Connection', 'table', 1, 'as', 'null'),
        new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper5edc98a7cce2\\Illuminate\\Database\\ConnectionInterface', 'table', 1, 'as', 'null'),
        new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper5edc98a7cce2\\Illuminate\\Database\\Query\\Builder', 'from', 1, 'as', 'null'),
    ])]]);
};
