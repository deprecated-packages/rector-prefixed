<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\Mapping\\ClassMetadataFactory', 'setEntityManager', 0, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\EntityManagerInterface')), new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\Tools\\DebugUnitOfWorkListener', 'dumpIdentityMap', 0, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\EntityManagerInterface'))])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ArgumentRemover('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\Persisters\\Entity\\AbstractEntityInheritancePersister', 'getSelectJoinColumnSQL', 4, null)])]]);
};
