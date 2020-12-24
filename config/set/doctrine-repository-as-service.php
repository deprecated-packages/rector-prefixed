<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector;
use _PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector;
use _PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddPropertyByParentRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveParentRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\AddPropertyByParent;
use _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector;
use _PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;
use _PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
/**
 * @see https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
 * @see https://tomasvotruba.com/blog/2018/04/02/rectify-turn-repositories-to-services-in-symfony/
 */
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # order matters, this needs to be first to correctly detect parent repository
    // covers "extends EntityRepository"
    $services->set(\_PhpScopere8e811afab72\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class);
    // covers "extends ServiceEntityRepository"
    // @see https://github.com/doctrine/DoctrineBundle/pull/727/files
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector::ANNOTATIONS_TO_REMOVE => ['method']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddPropertyByParentRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddPropertyByParentRector::PARENT_DEPENDENCIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\AddPropertyByParent('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', '_PhpScopere8e811afab72\\Doctrine\\ORM\\EntityManagerInterface')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::PARENT_CALLS_TO_PROPERTIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createQueryBuilder', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createResultSetMappingBuilder', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'clear', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'find', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findBy', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findAll', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'count', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'getClassName', 'entityRepository'), new \_PhpScopere8e811afab72\Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'matching', 'entityRepository')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::METHOD_CALL_TO_PROPERTY_FETCHES => ['getEntityManager' => 'entityManager']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveParentRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\RemoveParentRector::PARENT_TYPES_TO_REMOVE => ['_PhpScopere8e811afab72\\Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class);
};
