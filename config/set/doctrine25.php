<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping\\ClassMetadataFactory', 'setEntityManager', 0, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('_PhpScopere8e811afab72\\Doctrine\\ORM\\EntityManagerInterface')), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScopere8e811afab72\\Doctrine\\ORM\\Tools\\DebugUnitOfWorkListener', 'dumpIdentityMap', 0, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('_PhpScopere8e811afab72\\Doctrine\\ORM\\EntityManagerInterface'))])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover('_PhpScopere8e811afab72\\Doctrine\\ORM\\Persisters\\Entity\\AbstractEntityInheritancePersister', 'getSelectJoinColumnSQL', 4, null)])]]);
};
