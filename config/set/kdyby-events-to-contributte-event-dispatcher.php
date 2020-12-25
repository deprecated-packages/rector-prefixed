<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector;
use Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector;
use Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector;
use Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector::class);
    $services->set(\Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector::class);
    $services->set(\Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector::class);
    $services->set(\Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Kdyby\\Events\\Subscriber' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScoperbf340cb0be9d\\Kdyby\\Events\\EventManager' => '_PhpScoperbf340cb0be9d\\Symfony\\Contracts\\EventDispatcher\\EventDispatcherInterface']]]);
};
