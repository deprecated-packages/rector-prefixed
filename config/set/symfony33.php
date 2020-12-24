<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'compile', 2, '__unknown__', 0), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'addCompilerPass', 2, 'priority', 0), new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentAdder('_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\Compiler\\ServiceReferenceGraph', 'connect', 6, 'weak', \false)])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # console
        '_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Event\\ConsoleExceptionEvent' => '_PhpScopere8e811afab72\\Symfony\\Component\\Console\\Event\\ConsoleErrorEvent',
        # debug
        '_PhpScopere8e811afab72\\Symfony\\Component\\Debug\\Exception\\ContextErrorException' => 'ErrorException',
        # dependency-injection
        '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\DefinitionDecorator' => '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\ChildDefinition',
        # framework bundle
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\AddConsoleCommandPass' => '_PhpScopere8e811afab72\\Symfony\\Component\\Console\\DependencyInjection\\AddConsoleCommandPass',
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\SerializerPass' => '_PhpScopere8e811afab72\\Symfony\\Component\\Serializer\\DependencyInjection\\SerializerPass',
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\FormPass' => '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\DependencyInjection\\FormPass',
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\SessionListener' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\EventListener\\SessionListener',
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\TestSessionListenr' => '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\EventListener\\TestSessionListener',
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\ConfigCachePass' => '_PhpScopere8e811afab72\\Symfony\\Component\\Config\\DependencyInjection\\ConfigCachePass',
        '_PhpScopere8e811afab72\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\PropertyInfoPass' => '_PhpScopere8e811afab72\\Symfony\\Component\\PropertyInfo\\DependencyInjection\\PropertyInfoPass',
    ]]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\Container', 'isFrozen', 'isCompiled')])]]);
};
