<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector;
use Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector;
use Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector;
use Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector::class);
    $services->set(\Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector::class);
    $services->set(\Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicEventPropertySubscriberWithEventClassSubscriberRector::class);
    $services->set(\Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix2020DecSat\\Kdyby\\Events\\Subscriber' => 'RectorPrefix2020DecSat\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', 'RectorPrefix2020DecSat\\Kdyby\\Events\\EventManager' => 'RectorPrefix2020DecSat\\Symfony\\Contracts\\EventDispatcher\\EventDispatcherInterface']]]);
};
