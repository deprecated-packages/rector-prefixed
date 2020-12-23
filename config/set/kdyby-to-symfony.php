<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a2ac50786fa\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', 'static')])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a2ac50786fa\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScoper0a2ac50786fa\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScoper0a2ac50786fa\\Kdyby\\RabbitMq\\IProducer' => '_PhpScoper0a2ac50786fa\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScoper0a2ac50786fa\\Kdyby\\Monolog\\Logger' => '_PhpScoper0a2ac50786fa\\Psr\\Log\\LoggerInterface', '_PhpScoper0a2ac50786fa\\Kdyby\\Events\\Subscriber' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScoper0a2ac50786fa\\Kdyby\\Translation\\Translator' => '_PhpScoper0a2ac50786fa\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
