<?php

declare (strict_types=1);
namespace RectorPrefix20201226;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201226\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix20201226\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20201226\\PhpSpec\\Console\\IO' => 'RectorPrefix20201226\\PhpSpec\\Console\\ConsoleIO', 'RectorPrefix20201226\\PhpSpec\\IO\\IOInterface' => 'RectorPrefix20201226\\PhpSpec\\IO\\IO', 'RectorPrefix20201226\\PhpSpec\\Locator\\ResourceInterface' => 'RectorPrefix20201226\\PhpSpec\\Locator\\Resource', 'RectorPrefix20201226\\PhpSpec\\Locator\\ResourceLocatorInterface' => 'RectorPrefix20201226\\PhpSpec\\Locator\\ResourceLocator', 'RectorPrefix20201226\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => 'RectorPrefix20201226\\PhpSpec\\Formatter\\Presenter\\Presenter', 'RectorPrefix20201226\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => 'RectorPrefix20201226\\PhpSpec\\CodeGenerator\\Generator\\Generator', 'RectorPrefix20201226\\PhpSpec\\Extension\\ExtensionInterface' => 'RectorPrefix20201226\\PhpSpec\\Extension', 'RectorPrefix20201226\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => 'RectorPrefix20201226\\Phpspec\\CodeAnalysis\\AccessInspector', 'RectorPrefix20201226\\Phpspec\\Event\\EventInterface' => 'RectorPrefix20201226\\Phpspec\\Event\\PhpSpecEvent', 'RectorPrefix20201226\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => 'RectorPrefix20201226\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', 'RectorPrefix20201226\\PhpSpec\\Matcher\\MatcherInterface' => 'RectorPrefix20201226\\PhpSpec\\Matcher\\Matcher', 'RectorPrefix20201226\\PhpSpec\\Matcher\\MatchersProviderInterface' => 'RectorPrefix20201226\\PhpSpec\\Matcher\\MatchersProvider', 'RectorPrefix20201226\\PhpSpec\\SpecificationInterface' => 'RectorPrefix20201226\\PhpSpec\\Specification', 'RectorPrefix20201226\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => 'RectorPrefix20201226\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
