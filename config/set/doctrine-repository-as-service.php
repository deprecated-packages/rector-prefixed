<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\AddPropertyByParentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\RemoveParentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\AddPropertyByParent;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
/**
 * @see https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
 * @see https://tomasvotruba.com/blog/2018/04/02/rectify-turn-repositories-to-services-in-symfony/
 */
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # order matters, this needs to be first to correctly detect parent repository
    // covers "extends EntityRepository"
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class);
    // covers "extends ServiceEntityRepository"
    // @see https://github.com/doctrine/DoctrineBundle/pull/727/files
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector::ANNOTATIONS_TO_REMOVE => ['method']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\AddPropertyByParentRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\AddPropertyByParentRector::PARENT_DEPENDENCIES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\AddPropertyByParent('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', '_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\EntityManagerInterface')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::PARENT_CALLS_TO_PROPERTIES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createQueryBuilder', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createResultSetMappingBuilder', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'clear', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'find', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findBy', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findAll', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'count', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'getClassName', 'entityRepository'), new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'matching', 'entityRepository')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::METHOD_CALL_TO_PROPERTY_FETCHES => ['getEntityManager' => 'entityManager']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\RemoveParentRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\RemoveParentRector::PARENT_TYPES_TO_REMOVE => ['_PhpScoper2a4e7ab1ecbc\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class);
};
