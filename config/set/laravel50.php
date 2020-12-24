<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.0/upgrade
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://stackoverflow.com/a/24949656/1348344
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Illuminate\\Cache\\CacheManager' => '_PhpScopere8e811afab72\\Illuminate\\Contracts\\Cache\\Repository', '_PhpScopere8e811afab72\\Illuminate\\Database\\Eloquent\\SoftDeletingTrait' => '_PhpScopere8e811afab72\\Illuminate\\Database\\Eloquent\\SoftDeletes']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Pagination\\Paginator', 'links', 'render'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Pagination\\Paginator', 'getFrom', 'firstItem'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Pagination\\Paginator', 'getTo', 'lastItem'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Pagination\\Paginator', 'getPerPage', 'perPage'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Pagination\\Paginator', 'getCurrentPage', 'currentPage'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Pagination\\Paginator', 'getLastPage', 'lastPage'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Illuminate\\Contracts\\Pagination\\Paginator', 'getTotal', 'total')])]]);
};
