<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Generic\ValueObject\ChangeMethodVisibility;
use Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScopera143bcca66cb\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', 'static')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopera143bcca66cb\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScopera143bcca66cb\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScopera143bcca66cb\\Kdyby\\RabbitMq\\IProducer' => '_PhpScopera143bcca66cb\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScopera143bcca66cb\\Kdyby\\Monolog\\Logger' => '_PhpScopera143bcca66cb\\Psr\\Log\\LoggerInterface', '_PhpScopera143bcca66cb\\Kdyby\\Events\\Subscriber' => '_PhpScopera143bcca66cb\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScopera143bcca66cb\\Kdyby\\Translation\\Translator' => '_PhpScopera143bcca66cb\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
