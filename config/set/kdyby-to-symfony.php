<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Core\ValueObject\Visibility;
use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Generic\ValueObject\ChangeMethodVisibility;
use Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ChangeMethodVisibility('RectorPrefix2020DecSat\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', \Rector\Core\ValueObject\Visibility::STATIC)])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix2020DecSat\\Kdyby\\RabbitMq\\IConsumer' => 'RectorPrefix2020DecSat\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', 'RectorPrefix2020DecSat\\Kdyby\\RabbitMq\\IProducer' => 'RectorPrefix2020DecSat\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', 'RectorPrefix2020DecSat\\Kdyby\\Monolog\\Logger' => 'RectorPrefix2020DecSat\\Psr\\Log\\LoggerInterface', 'RectorPrefix2020DecSat\\Kdyby\\Events\\Subscriber' => 'RectorPrefix2020DecSat\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', 'RectorPrefix2020DecSat\\Kdyby\\Translation\\Translator' => 'RectorPrefix2020DecSat\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
