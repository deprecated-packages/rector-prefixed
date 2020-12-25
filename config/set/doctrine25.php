<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use PHPStan\Type\ObjectType;
use Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Generic\ValueObject\ArgumentRemover;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('Doctrine\\ORM\\Mapping\\ClassMetadataFactory', 'setEntityManager', 0, new \PHPStan\Type\ObjectType('_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\EntityManagerInterface')), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\Tools\\DebugUnitOfWorkListener', 'dumpIdentityMap', 0, new \PHPStan\Type\ObjectType('_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\EntityManagerInterface'))])]]);
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentRemover('_PhpScoperbf340cb0be9d\\Doctrine\\ORM\\Persisters\\Entity\\AbstractEntityInheritancePersister', 'getSelectJoinColumnSQL', 4, null)])]]);
};
