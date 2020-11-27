<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

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
    $services->set(\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperbd5d0c5f7638\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', 'static')])]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbd5d0c5f7638\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbd5d0c5f7638\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbd5d0c5f7638\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScoperbd5d0c5f7638\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScoperbd5d0c5f7638\\Kdyby\\RabbitMq\\IProducer' => '_PhpScoperbd5d0c5f7638\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScoperbd5d0c5f7638\\Kdyby\\Monolog\\Logger' => '_PhpScoperbd5d0c5f7638\\Psr\\Log\\LoggerInterface', '_PhpScoperbd5d0c5f7638\\Kdyby\\Events\\Subscriber' => '_PhpScoperbd5d0c5f7638\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScoperbd5d0c5f7638\\Kdyby\\Translation\\Translator' => '_PhpScoperbd5d0c5f7638\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
