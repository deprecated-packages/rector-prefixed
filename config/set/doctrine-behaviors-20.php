<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoper50d83356d739\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
