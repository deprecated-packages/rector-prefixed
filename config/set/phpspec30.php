<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper2a4e7ab1ecbc\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Console\\IO' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\IO\\IOInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\IO\\IO', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Locator\\Resource', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Extension', '_PhpScoper2a4e7ab1ecbc\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper2a4e7ab1ecbc\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper2a4e7ab1ecbc\\Phpspec\\Event\\EventInterface' => '_PhpScoper2a4e7ab1ecbc\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Matcher\\Matcher', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\SpecificationInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Specification', '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper2a4e7ab1ecbc\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
