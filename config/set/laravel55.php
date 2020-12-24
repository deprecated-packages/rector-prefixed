<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.5/upgrade
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Console\\Command', 'fire', 'handle')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty('_PhpScopere8e811afab72\\Illuminate\\Database\\Eloquent\\Concerns\\HasEvents', 'events', 'dispatchesEvents'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameProperty('_PhpScopere8e811afab72\\Illuminate\\Database\\Eloquent\\Relations\\Pivot', 'parent', 'pivotParent')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Illuminate\\Translation\\LoaderInterface' => '_PhpScopere8e811afab72\\Illuminate\\Contracts\\Translation\\Loader']]]);
};
