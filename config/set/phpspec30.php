<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper17db12703726\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper17db12703726\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper17db12703726\\PhpSpec\\Console\\IO' => '_PhpScoper17db12703726\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper17db12703726\\PhpSpec\\IO\\IOInterface' => '_PhpScoper17db12703726\\PhpSpec\\IO\\IO', '_PhpScoper17db12703726\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper17db12703726\\PhpSpec\\Locator\\Resource', '_PhpScoper17db12703726\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper17db12703726\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper17db12703726\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper17db12703726\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper17db12703726\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper17db12703726\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper17db12703726\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper17db12703726\\PhpSpec\\Extension', '_PhpScoper17db12703726\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper17db12703726\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper17db12703726\\Phpspec\\Event\\EventInterface' => '_PhpScoper17db12703726\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper17db12703726\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper17db12703726\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper17db12703726\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper17db12703726\\PhpSpec\\Matcher\\Matcher', '_PhpScoper17db12703726\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper17db12703726\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper17db12703726\\PhpSpec\\SpecificationInterface' => '_PhpScoper17db12703726\\PhpSpec\\Specification', '_PhpScoper17db12703726\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper17db12703726\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
