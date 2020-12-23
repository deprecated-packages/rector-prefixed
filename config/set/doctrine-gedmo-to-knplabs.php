<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\BlameableBehaviorRector;
use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\LoggableBehaviorRector;
use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SluggableBehaviorRector;
use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SoftDeletableBehaviorRector;
use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TimestampableBehaviorRector;
use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector;
use _PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# version gedmo/doctrine-extensions 2.x to knplabs/doctrine-behaviors 2.0
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TimestampableBehaviorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SluggableBehaviorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TreeBehaviorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\TranslationBehaviorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\SoftDeletableBehaviorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\BlameableBehaviorRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\DoctrineGedmoToKnplabs\Rector\Class_\LoggableBehaviorRector::class);
};
