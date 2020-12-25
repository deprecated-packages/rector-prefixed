<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# see https://github.com/doctrine/persistence/pull/71
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Event\\LifecycleEventArgs' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Event\\LifecycleEventArgs', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Event\\LoadClassMetadataEventArgs' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Event\\LoadClassMetadataEventArgs', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Event\\ManagerEventArgs' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Event\\ManagerEventArgs', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\AbstractClassMetadataFactory' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\AbstractClassMetadataFactory', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\ClassMetadata' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\ClassMetadata', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\ClassMetadataFactory' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\ClassMetadataFactory', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\Driver\\FileDriver' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\Driver\\FileDriver', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\Driver\\MappingDriver' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\Driver\\MappingDriver', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\Driver\\MappingDriverChain' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\Driver\\MappingDriverChain', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\Driver\\PHPDriver' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\Driver\\PHPDriver', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\Driver\\StaticPHPDriver' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\Driver\\StaticPHPDriver', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\Driver\\SymfonyFileLocator' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\Driver\\SymfonyFileLocator', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\MappingException' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\MappingException', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\ReflectionService' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\ReflectionService', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\RuntimeReflectionService' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\RuntimeReflectionService', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\StaticReflectionService' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\StaticReflectionService', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\ObjectManager' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\ObjectManager', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\ObjectManagerDecorator' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\ObjectManagerDecorator', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\ObjectRepository' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\ObjectRepository', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Proxy' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Proxy', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\AbstractManagerRegistry' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\AbstractManagerRegistry', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\Mapping\\Driver\\DefaultFileLocator' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\Mapping\\Driver\\DefaultFileLocator', '_PhpScoperbf340cb0be9d\\Doctrine\\Common\\Persistence\\ManagerRegistry' => '_PhpScoperbf340cb0be9d\\Doctrine\\Persistence\\ManagerRegistry']]]);
};
