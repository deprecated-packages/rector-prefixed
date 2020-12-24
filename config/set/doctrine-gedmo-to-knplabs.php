<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\BlameableBehaviorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\LoggableBehaviorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SluggableBehaviorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SoftDeletableBehaviorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TimestampableBehaviorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector;
use _PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# version gedmo/doctrine-extensions 2.x to knplabs/doctrine-behaviors 2.0
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TimestampableBehaviorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SluggableBehaviorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SoftDeletableBehaviorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\BlameableBehaviorRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\DoctrineGedmoToKnplabs\Rector\Class_\LoggableBehaviorRector::class);
};
