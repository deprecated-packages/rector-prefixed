<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\PhpSpec\\Console\\IO' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Console\\ConsoleIO', '_PhpScoperbf340cb0be9d\\PhpSpec\\IO\\IOInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\IO\\IO', '_PhpScoperbf340cb0be9d\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Locator\\Resource', '_PhpScoperbf340cb0be9d\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoperbf340cb0be9d\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoperbf340cb0be9d\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoperbf340cb0be9d\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Extension', '_PhpScoperbf340cb0be9d\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoperbf340cb0be9d\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoperbf340cb0be9d\\Phpspec\\Event\\EventInterface' => '_PhpScoperbf340cb0be9d\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoperbf340cb0be9d\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoperbf340cb0be9d\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Matcher\\Matcher', '_PhpScoperbf340cb0be9d\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoperbf340cb0be9d\\PhpSpec\\SpecificationInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Specification', '_PhpScoperbf340cb0be9d\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoperbf340cb0be9d\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
