<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/doctrine/dbal/blob/master/UPGRADE.md#bc-break-changes-in-handling-string-and-binary-columns
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Platforms\\AbstractPlatform', 'getVarcharTypeDeclarationSQL', 'getStringTypeDeclarationSQL'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getCode')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'ping', new \_PhpScopere8e811afab72\PHPStan\Type\VoidType())])]]);
    # https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-abstractionresult
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Doctrine\\DBAL\\Abstraction\\Result' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Result']]]);
};
