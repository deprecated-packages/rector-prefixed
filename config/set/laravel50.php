<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.0/upgrade
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://stackoverflow.com/a/24949656/1348344
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Illuminate\\Cache\\CacheManager' => '_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Cache\\Repository', '_PhpScoperbf340cb0be9d\\Illuminate\\Database\\Eloquent\\SoftDeletingTrait' => '_PhpScoperbf340cb0be9d\\Illuminate\\Database\\Eloquent\\SoftDeletes']]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Pagination\\Paginator', 'links', 'render'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Pagination\\Paginator', 'getFrom', 'firstItem'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Pagination\\Paginator', 'getTo', 'lastItem'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Pagination\\Paginator', 'getPerPage', 'perPage'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Pagination\\Paginator', 'getCurrentPage', 'currentPage'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Pagination\\Paginator', 'getLastPage', 'lastPage'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Pagination\\Paginator', 'getTotal', 'total')])]]);
};
