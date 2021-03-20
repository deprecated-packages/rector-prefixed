<?php

declare (strict_types=1);
namespace RectorPrefix20210320;

use Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector;
use Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicPropertyWithEventClassRector;
use Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector;
use Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\NetteKdyby\Rector\ClassMethod\ChangeNetteEventNamesInGetSubscribedEventsRector::class);
    $services->set(\Rector\NetteKdyby\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector::class);
    $services->set(\Rector\NetteKdyby\Rector\ClassMethod\ReplaceMagicPropertyWithEventClassRector::class);
    $services->set(\Rector\NetteKdyby\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Kdyby\\Events\\Subscriber' => 'Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', 'Kdyby\\Events\\EventManager' => 'Symfony\\Contracts\\EventDispatcher\\EventDispatcherInterface']]]);
};
