<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper8b9c402c5f32\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'compile', 2, '__unknown__', 0), new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper8b9c402c5f32\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'addCompilerPass', 2, 'priority', 0), new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoper8b9c402c5f32\\Symfony\\Component\\DependencyInjection\\Compiler\\ServiceReferenceGraph', 'connect', 6, 'weak', \false)])]]);
    $services->set(\Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # console
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Console\\Event\\ConsoleExceptionEvent' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Console\\Event\\ConsoleErrorEvent',
        # debug
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Debug\\Exception\\ContextErrorException' => 'ErrorException',
        # dependency-injection
        '_PhpScoper8b9c402c5f32\\Symfony\\Component\\DependencyInjection\\DefinitionDecorator' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\DependencyInjection\\ChildDefinition',
        # framework bundle
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\AddConsoleCommandPass' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Console\\DependencyInjection\\AddConsoleCommandPass',
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\SerializerPass' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Serializer\\DependencyInjection\\SerializerPass',
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\FormPass' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Form\\DependencyInjection\\FormPass',
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\SessionListener' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\EventListener\\SessionListener',
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\TestSessionListenr' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\HttpKernel\\EventListener\\TestSessionListener',
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\ConfigCachePass' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Config\\DependencyInjection\\ConfigCachePass',
        '_PhpScoper8b9c402c5f32\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\PropertyInfoPass' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\PropertyInfo\\DependencyInjection\\PropertyInfoPass',
    ]]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\Symfony\\Component\\DependencyInjection\\Container', 'isFrozen', 'isCompiled')])]]);
};
