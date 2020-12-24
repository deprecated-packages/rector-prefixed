<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.6/upgrade
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Illuminate\\Validation\\ValidatesWhenResolvedTrait', 'validate', 'validateResolved'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Validation\\ValidatesWhenResolved', 'validate', 'validateResolved')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Illuminate\\Routing\\Router', 'addRoute', 'public'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'raw', 'public'), new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Illuminate\\Database\\Grammar', 'getDateFormat', 'public')])]]);
};
