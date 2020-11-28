<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperabd03f0baf05\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperabd03f0baf05\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperabd03f0baf05\\PhpSpec\\Console\\IO' => '_PhpScoperabd03f0baf05\\PhpSpec\\Console\\ConsoleIO', '_PhpScoperabd03f0baf05\\PhpSpec\\IO\\IOInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\IO\\IO', '_PhpScoperabd03f0baf05\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Locator\\Resource', '_PhpScoperabd03f0baf05\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoperabd03f0baf05\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoperabd03f0baf05\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoperabd03f0baf05\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Extension', '_PhpScoperabd03f0baf05\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoperabd03f0baf05\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoperabd03f0baf05\\Phpspec\\Event\\EventInterface' => '_PhpScoperabd03f0baf05\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoperabd03f0baf05\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoperabd03f0baf05\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Matcher\\Matcher', '_PhpScoperabd03f0baf05\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoperabd03f0baf05\\PhpSpec\\SpecificationInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Specification', '_PhpScoperabd03f0baf05\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoperabd03f0baf05\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
