<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopera143bcca66cb\\PhpSpec\\Console\\IO' => '_PhpScopera143bcca66cb\\PhpSpec\\Console\\ConsoleIO', '_PhpScopera143bcca66cb\\PhpSpec\\IO\\IOInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\IO\\IO', '_PhpScopera143bcca66cb\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Locator\\Resource', '_PhpScopera143bcca66cb\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Locator\\ResourceLocator', '_PhpScopera143bcca66cb\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScopera143bcca66cb\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScopera143bcca66cb\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Extension', '_PhpScopera143bcca66cb\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScopera143bcca66cb\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScopera143bcca66cb\\Phpspec\\Event\\EventInterface' => '_PhpScopera143bcca66cb\\Phpspec\\Event\\PhpSpecEvent', '_PhpScopera143bcca66cb\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScopera143bcca66cb\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Matcher\\Matcher', '_PhpScopera143bcca66cb\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScopera143bcca66cb\\PhpSpec\\SpecificationInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Specification', '_PhpScopera143bcca66cb\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScopera143bcca66cb\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
