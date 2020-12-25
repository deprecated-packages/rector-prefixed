<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoper8b9c402c5f32\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
