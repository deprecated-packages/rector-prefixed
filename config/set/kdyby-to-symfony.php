<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoper2a4e7ab1ecbc\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', 'static')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper2a4e7ab1ecbc\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScoper2a4e7ab1ecbc\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScoper2a4e7ab1ecbc\\Kdyby\\RabbitMq\\IProducer' => '_PhpScoper2a4e7ab1ecbc\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScoper2a4e7ab1ecbc\\Kdyby\\Monolog\\Logger' => '_PhpScoper2a4e7ab1ecbc\\Psr\\Log\\LoggerInterface', '_PhpScoper2a4e7ab1ecbc\\Kdyby\\Events\\Subscriber' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScoper2a4e7ab1ecbc\\Kdyby\\Translation\\Translator' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
