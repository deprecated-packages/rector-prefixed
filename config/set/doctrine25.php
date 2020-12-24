<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\Mapping\\ClassMetadataFactory', 'setEntityManager', 0, new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityManagerInterface')), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\Tools\\DebugUnitOfWorkListener', 'dumpIdentityMap', 0, new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityManagerInterface'))])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ArgumentRemover('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\Persisters\\Entity\\AbstractEntityInheritancePersister', 'getSelectJoinColumnSQL', 4, null)])]]);
};
