<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', 'RectorPrefix20201227\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
