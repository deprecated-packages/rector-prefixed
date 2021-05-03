<?php

declare (strict_types=1);
namespace RectorPrefix20210503;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210503\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PhpSpec\\Console\\IO' => 'PhpSpec\\Console\\ConsoleIO', 'PhpSpec\\IO\\IOInterface' => 'PhpSpec\\IO\\IO', 'PhpSpec\\Locator\\ResourceInterface' => 'PhpSpec\\Locator\\Resource', 'PhpSpec\\Locator\\ResourceLocatorInterface' => 'PhpSpec\\Locator\\ResourceLocator', 'PhpSpec\\Formatter\\Presenter\\PresenterInterface' => 'PhpSpec\\Formatter\\Presenter\\Presenter', 'PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => 'PhpSpec\\CodeGenerator\\Generator\\Generator', 'PhpSpec\\Extension\\ExtensionInterface' => 'PhpSpec\\Extension', 'Phpspec\\CodeAnalysis\\AccessInspectorInterface' => 'Phpspec\\CodeAnalysis\\AccessInspector', 'Phpspec\\Event\\EventInterface' => 'Phpspec\\Event\\PhpSpecEvent', 'PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => 'PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', 'PhpSpec\\Matcher\\MatcherInterface' => 'PhpSpec\\Matcher\\Matcher', 'PhpSpec\\Matcher\\MatchersProviderInterface' => 'PhpSpec\\Matcher\\MatchersProvider', 'PhpSpec\\SpecificationInterface' => 'PhpSpec\\Specification', 'PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => 'PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
