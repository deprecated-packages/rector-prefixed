<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoperfce0de0de1ce\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
