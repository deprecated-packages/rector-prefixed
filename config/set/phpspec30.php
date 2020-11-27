<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper006a73f0e455\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper006a73f0e455\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper006a73f0e455\\PhpSpec\\Console\\IO' => '_PhpScoper006a73f0e455\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper006a73f0e455\\PhpSpec\\IO\\IOInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\IO\\IO', '_PhpScoper006a73f0e455\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Locator\\Resource', '_PhpScoper006a73f0e455\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper006a73f0e455\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper006a73f0e455\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper006a73f0e455\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Extension', '_PhpScoper006a73f0e455\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper006a73f0e455\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper006a73f0e455\\Phpspec\\Event\\EventInterface' => '_PhpScoper006a73f0e455\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper006a73f0e455\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper006a73f0e455\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Matcher\\Matcher', '_PhpScoper006a73f0e455\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper006a73f0e455\\PhpSpec\\SpecificationInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Specification', '_PhpScoper006a73f0e455\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper006a73f0e455\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
