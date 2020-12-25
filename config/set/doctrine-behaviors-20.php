<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoperbf340cb0be9d\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
