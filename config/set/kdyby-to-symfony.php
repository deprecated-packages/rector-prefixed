<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopere8e811afab72\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', 'static')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScopere8e811afab72\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScopere8e811afab72\\Kdyby\\RabbitMq\\IProducer' => '_PhpScopere8e811afab72\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScopere8e811afab72\\Kdyby\\Monolog\\Logger' => '_PhpScopere8e811afab72\\Psr\\Log\\LoggerInterface', '_PhpScopere8e811afab72\\Kdyby\\Events\\Subscriber' => '_PhpScopere8e811afab72\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScopere8e811afab72\\Kdyby\\Translation\\Translator' => '_PhpScopere8e811afab72\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
