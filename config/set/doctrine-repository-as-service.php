<?php

declare (strict_types=1);
namespace RectorPrefix20210125;

use Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector;
use Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector;
use Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector;
use Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector;
use Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector;
use Rector\Generic\Rector\Class_\AddPropertyByParentRector;
use Rector\Generic\Rector\Class_\RemoveParentRector;
use Rector\Generic\Rector\ClassLike\RemoveAnnotationRector;
use Rector\Generic\ValueObject\AddPropertyByParent;
use Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector;
use Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector;
use Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall;
use RectorPrefix20210125\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
/**
 * @see https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
 * @see https://tomasvotruba.com/blog/2018/04/02/rectify-turn-repositories-to-services-in-symfony/
 */
return static function (\RectorPrefix20210125\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # order matters, this needs to be first to correctly detect parent repository
    // covers "extends EntityRepository"
    $services->set(\Rector\DoctrineCodeQuality\Rector\Class_\MoveRepositoryFromParentToConstructorRector::class);
    $services->set(\Rector\Architecture\Rector\MethodCall\ServiceLocatorToDIRector::class);
    $services->set(\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class);
    $services->set(\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class);
    // covers "extends ServiceEntityRepository"
    // @see https://github.com/doctrine/DoctrineBundle/pull/727/files
    $services->set(\Rector\Doctrine\Rector\ClassMethod\ServiceEntityRepositoryParentCallToDIRector::class);
    $services->set(\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector::class)->call('configure', [[\Rector\Generic\Rector\ClassLike\RemoveAnnotationRector::ANNOTATIONS_TO_REMOVE => ['method']]]);
    $services->set(\Rector\Generic\Rector\Class_\AddPropertyByParentRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddPropertyByParentRector::PARENT_DEPENDENCIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\AddPropertyByParent('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'Doctrine\\ORM\\EntityManagerInterface')])]]);
    $services->set(\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\ReplaceParentCallByPropertyCallRector::PARENT_CALLS_TO_PROPERTIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createQueryBuilder', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'createResultSetMappingBuilder', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'clear', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'find', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findBy', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'findAll', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'count', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'getClassName', 'entityRepository'), new \Rector\Transform\ValueObject\ReplaceParentCallByPropertyCall('Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository', 'matching', 'entityRepository')])]]);
    $services->set(\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::class)->call('configure', [[\Rector\Transform\Rector\MethodCall\MethodCallToPropertyFetchRector::METHOD_CALL_TO_PROPERTY_FETCHES => ['getEntityManager' => 'entityManager']]]);
    $services->set(\Rector\Generic\Rector\Class_\RemoveParentRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\RemoveParentRector::PARENT_TYPES_TO_REMOVE => ['Doctrine\\Bundle\\DoctrineBundle\\Repository\\ServiceEntityRepository']]]);
    $services->set(\Rector\Doctrine\Rector\Class_\RemoveRepositoryFromEntityAnnotationRector::class);
    $services->set(\Rector\Architecture\Rector\MethodCall\ReplaceParentRepositoryCallsByRepositoryPropertyRector::class);
};
