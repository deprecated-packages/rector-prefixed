<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# see: https://laravel.com/docs/5.6/upgrade
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Illuminate\\Validation\\ValidatesWhenResolvedTrait', 'validate', 'validateResolved'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Validation\\ValidatesWhenResolved', 'validate', 'validateResolved')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Illuminate\\Routing\\Router', 'addRoute', 'public'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Illuminate\\Contracts\\Auth\\Access\\Gate', 'raw', 'public'), new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Illuminate\\Database\\Grammar', 'getDateFormat', 'public')])]]);
};
