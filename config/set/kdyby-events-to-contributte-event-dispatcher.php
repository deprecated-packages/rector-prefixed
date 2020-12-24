<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Kdyby\\Events\\Subscriber' => '_PhpScopere8e811afab72\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScopere8e811afab72\\Kdyby\\Events\\EventManager' => '_PhpScopere8e811afab72\\Symfony\\Contracts\\EventDispatcher\\EventDispatcherInterface']]]);
};
