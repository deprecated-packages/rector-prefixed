<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use PHPStan\Type\VoidType;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
# https://github.com/doctrine/dbal/blob/master/UPGRADE.md#bc-break-changes-in-handling-string-and-binary-columns
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Platforms\\AbstractPlatform', 'getVarcharTypeDeclarationSQL', 'getStringTypeDeclarationSQL'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getCode')])]]);
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'ping', new \PHPStan\Type\VoidType())])]]);
    # https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-abstractionresult
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Abstraction\\Result' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Result']]]);
};
