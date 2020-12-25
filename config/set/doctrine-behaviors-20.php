<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2;

use Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoper267b3276efc2\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
