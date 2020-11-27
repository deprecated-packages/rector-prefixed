<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper88fe6e0ad041\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper88fe6e0ad041\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper88fe6e0ad041\\PhpSpec\\Console\\IO' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper88fe6e0ad041\\PhpSpec\\IO\\IOInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\IO\\IO', '_PhpScoper88fe6e0ad041\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Locator\\Resource', '_PhpScoper88fe6e0ad041\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper88fe6e0ad041\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper88fe6e0ad041\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper88fe6e0ad041\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Extension', '_PhpScoper88fe6e0ad041\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper88fe6e0ad041\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper88fe6e0ad041\\Phpspec\\Event\\EventInterface' => '_PhpScoper88fe6e0ad041\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper88fe6e0ad041\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper88fe6e0ad041\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Matcher\\Matcher', '_PhpScoper88fe6e0ad041\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper88fe6e0ad041\\PhpSpec\\SpecificationInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Specification', '_PhpScoper88fe6e0ad041\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper88fe6e0ad041\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
