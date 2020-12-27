<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \RectorPrefix20201227\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201227\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20201227\\PhpSpec\\Console\\IO' => 'RectorPrefix20201227\\PhpSpec\\Console\\ConsoleIO', 'RectorPrefix20201227\\PhpSpec\\IO\\IOInterface' => 'RectorPrefix20201227\\PhpSpec\\IO\\IO', 'RectorPrefix20201227\\PhpSpec\\Locator\\ResourceInterface' => 'RectorPrefix20201227\\PhpSpec\\Locator\\Resource', 'RectorPrefix20201227\\PhpSpec\\Locator\\ResourceLocatorInterface' => 'RectorPrefix20201227\\PhpSpec\\Locator\\ResourceLocator', 'RectorPrefix20201227\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => 'RectorPrefix20201227\\PhpSpec\\Formatter\\Presenter\\Presenter', 'RectorPrefix20201227\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => 'RectorPrefix20201227\\PhpSpec\\CodeGenerator\\Generator\\Generator', 'RectorPrefix20201227\\PhpSpec\\Extension\\ExtensionInterface' => 'RectorPrefix20201227\\PhpSpec\\Extension', 'RectorPrefix20201227\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => 'RectorPrefix20201227\\Phpspec\\CodeAnalysis\\AccessInspector', 'RectorPrefix20201227\\Phpspec\\Event\\EventInterface' => 'RectorPrefix20201227\\Phpspec\\Event\\PhpSpecEvent', 'RectorPrefix20201227\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => 'RectorPrefix20201227\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', 'RectorPrefix20201227\\PhpSpec\\Matcher\\MatcherInterface' => 'RectorPrefix20201227\\PhpSpec\\Matcher\\Matcher', 'RectorPrefix20201227\\PhpSpec\\Matcher\\MatchersProviderInterface' => 'RectorPrefix20201227\\PhpSpec\\Matcher\\MatchersProvider', 'RectorPrefix20201227\\PhpSpec\\SpecificationInterface' => 'RectorPrefix20201227\\PhpSpec\\Specification', 'RectorPrefix20201227\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => 'RectorPrefix20201227\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
