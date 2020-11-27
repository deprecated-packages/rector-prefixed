<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScopera143bcca66cb\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
