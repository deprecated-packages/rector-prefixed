<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Core\ValueObject\Visibility;
use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Generic\ValueObject\ChangeMethodVisibility;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.6/upgrade
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Validation\\ValidatesWhenResolvedTrait', 'validate', 'validateResolved'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Validation\\ValidatesWhenResolved', 'validate', 'validateResolved')])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperbf340cb0be9d\\Illuminate\\Routing\\Router', 'addRoute', \Rector\Core\ValueObject\Visibility::PUBLIC), new \Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperbf340cb0be9d\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'raw', \Rector\Core\ValueObject\Visibility::PUBLIC), new \Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperbf340cb0be9d\\Illuminate\\Database\\Grammar', 'getDateFormat', \Rector\Core\ValueObject\Visibility::PUBLIC)])]]);
};
