<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\BlameableBehaviorRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\LoggableBehaviorRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SluggableBehaviorRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SoftDeletableBehaviorRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TimestampableBehaviorRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector;
use _PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# version gedmo/doctrine-extensions 2.x to knplabs/doctrine-behaviors 2.0
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TimestampableBehaviorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SluggableBehaviorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SoftDeletableBehaviorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\BlameableBehaviorRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DoctrineGedmoToKnplabs\Rector\Class_\LoggableBehaviorRector::class);
};
