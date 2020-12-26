<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix2020DecSat\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'compile', 2, '__unknown__', 0), new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix2020DecSat\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'addCompilerPass', 2, 'priority', 0), new \Rector\Generic\ValueObject\ArgumentAdder('RectorPrefix2020DecSat\\Symfony\\Component\\DependencyInjection\\Compiler\\ServiceReferenceGraph', 'connect', 6, 'weak', \false)])]]);
    $services->set(\Rector\Symfony3\Rector\ClassConstFetch\ConsoleExceptionToErrorEventConstantRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # console
        'RectorPrefix2020DecSat\\Symfony\\Component\\Console\\Event\\ConsoleExceptionEvent' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Console\\Event\\ConsoleErrorEvent',
        # debug
        'RectorPrefix2020DecSat\\Symfony\\Component\\Debug\\Exception\\ContextErrorException' => 'ErrorException',
        # dependency-injection
        'RectorPrefix2020DecSat\\Symfony\\Component\\DependencyInjection\\DefinitionDecorator' => 'RectorPrefix2020DecSat\\Symfony\\Component\\DependencyInjection\\ChildDefinition',
        # framework bundle
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\AddConsoleCommandPass' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Console\\DependencyInjection\\AddConsoleCommandPass',
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\SerializerPass' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Serializer\\DependencyInjection\\SerializerPass',
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\FormPass' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Form\\DependencyInjection\\FormPass',
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\SessionListener' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\EventListener\\SessionListener',
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\FrameworkBundle\\EventListener\\TestSessionListenr' => 'RectorPrefix2020DecSat\\Symfony\\Component\\HttpKernel\\EventListener\\TestSessionListener',
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\ConfigCachePass' => 'RectorPrefix2020DecSat\\Symfony\\Component\\Config\\DependencyInjection\\ConfigCachePass',
        'RectorPrefix2020DecSat\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\Compiler\\PropertyInfoPass' => 'RectorPrefix2020DecSat\\Symfony\\Component\\PropertyInfo\\DependencyInjection\\PropertyInfoPass',
    ]]]);
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\Symfony\\Component\\DependencyInjection\\Container', 'isFrozen', 'isCompiled')])]]);
};
