<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoper2a4e7ab1ecbc\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
