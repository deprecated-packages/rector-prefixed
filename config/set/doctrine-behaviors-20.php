<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\AddInterfaceByTraitRector::INTERFACE_BY_TRAIT => ['_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TimestampableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\BlameableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\LoggableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\SoftDeletableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslatableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TranslationInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\Uuidable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Uuidable\\UuidableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\UuidableInterface']]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # move interface to "Contract"
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Tree\\NodeInterface' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Contract\\Entity\\TreeNodeInterface',
        # suffix "Trait" for traits
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableMethodsTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableProperties' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameablePropertiesTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\Blameable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Blameable\\BlameableTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableMethodsTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableProperties' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodablePropertiesTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\Geocodable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Geocodable\\GeocodableTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Loggable\\Loggable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Loggable\\LoggableTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableMethodsTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableProperties' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggablePropertiesTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\Sluggable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Sluggable\\SluggableTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableMethodsTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableProperties' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletablePropertiesTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\SoftDeletable\\SoftDeletableTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableMethodsTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableProperties' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampablePropertiesTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\Timestampable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Timestampable\\TimestampableTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableMethodsTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableProperties' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatablePropertiesTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translatable' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslatableTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethods' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationMethodsTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationProperties' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationPropertiesTrait',
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait',
        # tree
        '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Tree\\Node' => '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Tree\\TreeNodeTrait',
    ]]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Class_\AddEntityIdByConditionRector::DETECTED_TRAITS => ['_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\Translation', '_PhpScoperb75b35f52b74\\Knp\\DoctrineBehaviors\\Model\\Translatable\\TranslationTrait']]]);
};
