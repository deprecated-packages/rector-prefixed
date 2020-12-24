<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \_PhpScoper0a6b37af0871\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a6b37af0871\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a6b37af0871\\PhpSpec\\Console\\IO' => '_PhpScoper0a6b37af0871\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper0a6b37af0871\\PhpSpec\\IO\\IOInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\IO\\IO', '_PhpScoper0a6b37af0871\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Locator\\Resource', '_PhpScoper0a6b37af0871\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper0a6b37af0871\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper0a6b37af0871\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper0a6b37af0871\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Extension', '_PhpScoper0a6b37af0871\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper0a6b37af0871\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper0a6b37af0871\\Phpspec\\Event\\EventInterface' => '_PhpScoper0a6b37af0871\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper0a6b37af0871\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper0a6b37af0871\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Matcher\\Matcher', '_PhpScoper0a6b37af0871\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper0a6b37af0871\\PhpSpec\\SpecificationInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Specification', '_PhpScoper0a6b37af0871\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper0a6b37af0871\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
