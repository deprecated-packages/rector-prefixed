<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper567b66d83109\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper567b66d83109\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper567b66d83109\\PhpSpec\\Console\\IO' => '_PhpScoper567b66d83109\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper567b66d83109\\PhpSpec\\IO\\IOInterface' => '_PhpScoper567b66d83109\\PhpSpec\\IO\\IO', '_PhpScoper567b66d83109\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Locator\\Resource', '_PhpScoper567b66d83109\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper567b66d83109\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper567b66d83109\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper567b66d83109\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper567b66d83109\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Extension', '_PhpScoper567b66d83109\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper567b66d83109\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper567b66d83109\\Phpspec\\Event\\EventInterface' => '_PhpScoper567b66d83109\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper567b66d83109\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper567b66d83109\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Matcher\\Matcher', '_PhpScoper567b66d83109\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper567b66d83109\\PhpSpec\\SpecificationInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Specification', '_PhpScoper567b66d83109\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper567b66d83109\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
