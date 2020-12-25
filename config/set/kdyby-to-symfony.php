<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Core\ValueObject\Visibility;
use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Generic\ValueObject\ChangeMethodVisibility;
use Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperbf340cb0be9d\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', \Rector\Core\ValueObject\Visibility::STATIC)])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScoperbf340cb0be9d\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScoperbf340cb0be9d\\Kdyby\\RabbitMq\\IProducer' => '_PhpScoperbf340cb0be9d\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScoperbf340cb0be9d\\Kdyby\\Monolog\\Logger' => '_PhpScoperbf340cb0be9d\\Psr\\Log\\LoggerInterface', '_PhpScoperbf340cb0be9d\\Kdyby\\Events\\Subscriber' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScoperbf340cb0be9d\\Kdyby\\Translation\\Translator' => '_PhpScoperbf340cb0be9d\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
