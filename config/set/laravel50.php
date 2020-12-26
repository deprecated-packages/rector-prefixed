<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.0/upgrade
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # https://stackoverflow.com/a/24949656/1348344
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix2020DecSat\\Illuminate\\Cache\\CacheManager' => 'RectorPrefix2020DecSat\\Illuminate\\Contracts\\Cache\\Repository', 'RectorPrefix2020DecSat\\Illuminate\\Database\\Eloquent\\SoftDeletingTrait' => 'RectorPrefix2020DecSat\\Illuminate\\Database\\Eloquent\\SoftDeletes']]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Illuminate\\Contracts\\Pagination\\Paginator', 'links', 'render'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Illuminate\\Contracts\\Pagination\\Paginator', 'getFrom', 'firstItem'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Illuminate\\Contracts\\Pagination\\Paginator', 'getTo', 'lastItem'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Illuminate\\Contracts\\Pagination\\Paginator', 'getPerPage', 'perPage'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Illuminate\\Contracts\\Pagination\\Paginator', 'getCurrentPage', 'currentPage'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Illuminate\\Contracts\\Pagination\\Paginator', 'getLastPage', 'lastPage'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Illuminate\\Contracts\\Pagination\\Paginator', 'getTotal', 'total')])]]);
};
