<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.6/upgrade
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Validation\\ValidatesWhenResolvedTrait', 'validate', 'validateResolved'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Validation\\ValidatesWhenResolved', 'validate', 'validateResolved')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Illuminate\\Routing\\Router', 'addRoute', 'public'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'raw', 'public'), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Illuminate\\Database\\Grammar', 'getDateFormat', 'public')])]]);
};
