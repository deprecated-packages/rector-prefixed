<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoperbd5d0c5f7638\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
