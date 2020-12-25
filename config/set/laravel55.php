<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\RenameProperty;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.5/upgrade
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Console\\Command', 'fire', 'handle')])]]);
    $services->set(\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameProperty('_PhpScoperbf340cb0be9d\\Illuminate\\Database\\Eloquent\\Concerns\\HasEvents', 'events', 'dispatchesEvents'), new \Rector\Renaming\ValueObject\RenameProperty('_PhpScoperbf340cb0be9d\\Illuminate\\Database\\Eloquent\\Relations\\Pivot', 'parent', 'pivotParent')])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Illuminate\\Translation\\LoaderInterface' => '_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Translation\\Loader']]]);
};
