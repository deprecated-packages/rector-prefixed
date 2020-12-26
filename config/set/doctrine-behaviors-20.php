<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', 'RectorPrefix2020DecSat\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
