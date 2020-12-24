<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility;
use _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\ChangeMethodVisibility('_PhpScoperb75b35f52b74\\Kdyby\\Events\\Subscriber', 'getSubscribedEvents', 'static')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Kdyby\\Translation\\Translator', 'translate', 'trans'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Kdyby\\RabbitMq\\IConsumer', 'process', 'execute')])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\Kdyby\\RabbitMq\\IConsumer' => '_PhpScoperb75b35f52b74\\OldSound\\RabbitMqBundle\\RabbitMq\\ConsumerInterface', '_PhpScoperb75b35f52b74\\Kdyby\\RabbitMq\\IProducer' => '_PhpScoperb75b35f52b74\\OldSound\\RabbitMqBundle\\RabbitMq\\ProducerInterface', '_PhpScoperb75b35f52b74\\Kdyby\\Monolog\\Logger' => '_PhpScoperb75b35f52b74\\Psr\\Log\\LoggerInterface', '_PhpScoperb75b35f52b74\\Kdyby\\Events\\Subscriber' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', '_PhpScoperb75b35f52b74\\Kdyby\\Translation\\Translator' => '_PhpScoperb75b35f52b74\\Symfony\\Contracts\\Translation\\TranslatorInterface']]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\NetteToSymfony\Rector\MethodCall\WrapTransParameterNameRector::class);
};
