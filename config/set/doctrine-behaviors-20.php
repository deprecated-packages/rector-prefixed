<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use _PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScopere8e811afab72\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
