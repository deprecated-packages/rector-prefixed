<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoperabd03f0baf05\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
