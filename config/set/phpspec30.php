<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\PhpSpec\\Console\\IO' => '_PhpScopere8e811afab72\\PhpSpec\\Console\\ConsoleIO', '_PhpScopere8e811afab72\\PhpSpec\\IO\\IOInterface' => '_PhpScopere8e811afab72\\PhpSpec\\IO\\IO', '_PhpScopere8e811afab72\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Locator\\Resource', '_PhpScopere8e811afab72\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Locator\\ResourceLocator', '_PhpScopere8e811afab72\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScopere8e811afab72\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScopere8e811afab72\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScopere8e811afab72\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Extension', '_PhpScopere8e811afab72\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScopere8e811afab72\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScopere8e811afab72\\Phpspec\\Event\\EventInterface' => '_PhpScopere8e811afab72\\Phpspec\\Event\\PhpSpecEvent', '_PhpScopere8e811afab72\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScopere8e811afab72\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Matcher\\Matcher', '_PhpScopere8e811afab72\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScopere8e811afab72\\PhpSpec\\SpecificationInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Specification', '_PhpScopere8e811afab72\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScopere8e811afab72\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
