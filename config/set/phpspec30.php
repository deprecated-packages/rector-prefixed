<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5edc98a7cce2\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper5edc98a7cce2\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper5edc98a7cce2\\PhpSpec\\Console\\IO' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper5edc98a7cce2\\PhpSpec\\IO\\IOInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\IO\\IO', '_PhpScoper5edc98a7cce2\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Locator\\Resource', '_PhpScoper5edc98a7cce2\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper5edc98a7cce2\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper5edc98a7cce2\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper5edc98a7cce2\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Extension', '_PhpScoper5edc98a7cce2\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper5edc98a7cce2\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper5edc98a7cce2\\Phpspec\\Event\\EventInterface' => '_PhpScoper5edc98a7cce2\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper5edc98a7cce2\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper5edc98a7cce2\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Matcher\\Matcher', '_PhpScoper5edc98a7cce2\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper5edc98a7cce2\\PhpSpec\\SpecificationInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Specification', '_PhpScoper5edc98a7cce2\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper5edc98a7cce2\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
