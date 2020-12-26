<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('RectorPrefix2020DecSat\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix2020DecSat\\PhpSpec\\Console\\IO' => 'RectorPrefix2020DecSat\\PhpSpec\\Console\\ConsoleIO', 'RectorPrefix2020DecSat\\PhpSpec\\IO\\IOInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\IO\\IO', 'RectorPrefix2020DecSat\\PhpSpec\\Locator\\ResourceInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Locator\\Resource', 'RectorPrefix2020DecSat\\PhpSpec\\Locator\\ResourceLocatorInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Locator\\ResourceLocator', 'RectorPrefix2020DecSat\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Formatter\\Presenter\\Presenter', 'RectorPrefix2020DecSat\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\CodeGenerator\\Generator\\Generator', 'RectorPrefix2020DecSat\\PhpSpec\\Extension\\ExtensionInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Extension', 'RectorPrefix2020DecSat\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => 'RectorPrefix2020DecSat\\Phpspec\\CodeAnalysis\\AccessInspector', 'RectorPrefix2020DecSat\\Phpspec\\Event\\EventInterface' => 'RectorPrefix2020DecSat\\Phpspec\\Event\\PhpSpecEvent', 'RectorPrefix2020DecSat\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', 'RectorPrefix2020DecSat\\PhpSpec\\Matcher\\MatcherInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Matcher\\Matcher', 'RectorPrefix2020DecSat\\PhpSpec\\Matcher\\MatchersProviderInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Matcher\\MatchersProvider', 'RectorPrefix2020DecSat\\PhpSpec\\SpecificationInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Specification', 'RectorPrefix2020DecSat\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => 'RectorPrefix2020DecSat\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
