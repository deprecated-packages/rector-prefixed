<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'compile', 2, '__unknown__', 0), new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'addCompilerPass', 2, 'priority', 0), new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\Compiler\\ServiceReferenceGraph', 'connect', 6, 'weak', \false)])]]);
    $services->set(\Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # console
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Console\\Event\\ConsoleExceptionEvent' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Console\\Event\\ConsoleErrorEvent',
        # debug
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Debug\\Exception\\ContextErrorException' => 'ErrorException',
        # dependency-injection
        '_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\DefinitionDecorator' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\ChildDefinition',
        # framework bundle
        '_PhpScoperbf340cb0be9d\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\AddConsoleCommandPass' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Console\\DependencyInjection\\AddConsoleCommandPass',
        '_PhpScoperbf340cb0be9d\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\SerializerPass' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Serializer\\DependencyInjection\\SerializerPass',
        '_PhpScoperbf340cb0be9d\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\FormPass' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Form\\DependencyInjection\\FormPass',
        '_PhpScoperbf340cb0be9d\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\SessionListener' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\EventListener\\SessionListener',
        '_PhpScoperbf340cb0be9d\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\TestSessionListenr' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\HttpKernel\\EventListener\\TestSessionListener',
        '_PhpScoperbf340cb0be9d\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\ConfigCachePass' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Config\\DependencyInjection\\ConfigCachePass',
        '_PhpScoperbf340cb0be9d\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\PropertyInfoPass' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\PropertyInfo\\DependencyInjection\\PropertyInfoPass',
    ]]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\Container', 'isFrozen', 'isCompiled')])]]);
};
