<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\Mapping\\ClassMetadataFactory', 'setEntityManager', 0, new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\EntityManagerInterface')), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\Tools\\DebugUnitOfWorkListener', 'dumpIdentityMap', 0, new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\EntityManagerInterface'))])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ArgumentRemover('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\Persisters\\Entity\\AbstractEntityInheritancePersister', 'getSelectJoinColumnSQL', 4, null)])]]);
};
