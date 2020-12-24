<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper0a6b37af0871\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', 'static')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a6b37af0871\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScoper0a6b37af0871\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScoper0a6b37af0871\\Kdyby\\RabbitMq\\IProducer' => '_PhpScoper0a6b37af0871\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScoper0a6b37af0871\\Kdyby\\Monolog\\Logger' => '_PhpScoper0a6b37af0871\\Psr\\Log\\LoggerInterface', '_PhpScoper0a6b37af0871\\Kdyby\\Events\\Subscriber' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScoper0a6b37af0871\\Kdyby\\Translation\\Translator' => '_PhpScoper0a6b37af0871\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
