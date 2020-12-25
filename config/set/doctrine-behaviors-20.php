<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoper17db12703726\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
