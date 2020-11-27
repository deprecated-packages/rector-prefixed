<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbd5d0c5f7638\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbd5d0c5f7638\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbd5d0c5f7638\\PhpSpec\\Console\\IO' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Console\\ConsoleIO', '_PhpScoperbd5d0c5f7638\\PhpSpec\\IO\\IOInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\IO\\IO', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Locator\\Resource', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoperbd5d0c5f7638\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Extension', '_PhpScoperbd5d0c5f7638\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoperbd5d0c5f7638\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoperbd5d0c5f7638\\Phpspec\\Event\\EventInterface' => '_PhpScoperbd5d0c5f7638\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Matcher\\Matcher', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoperbd5d0c5f7638\\PhpSpec\\SpecificationInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Specification', '_PhpScoperbd5d0c5f7638\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoperbd5d0c5f7638\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
