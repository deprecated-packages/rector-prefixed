<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperfce0de0de1ce\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperfce0de0de1ce\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperfce0de0de1ce\\PhpSpec\\Console\\IO' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Console\\ConsoleIO', '_PhpScoperfce0de0de1ce\\PhpSpec\\IO\\IOInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\IO\\IO', '_PhpScoperfce0de0de1ce\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Locator\\Resource', '_PhpScoperfce0de0de1ce\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoperfce0de0de1ce\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoperfce0de0de1ce\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoperfce0de0de1ce\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Extension', '_PhpScoperfce0de0de1ce\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoperfce0de0de1ce\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoperfce0de0de1ce\\Phpspec\\Event\\EventInterface' => '_PhpScoperfce0de0de1ce\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoperfce0de0de1ce\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoperfce0de0de1ce\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Matcher\\Matcher', '_PhpScoperfce0de0de1ce\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoperfce0de0de1ce\\PhpSpec\\SpecificationInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Specification', '_PhpScoperfce0de0de1ce\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoperfce0de0de1ce\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
