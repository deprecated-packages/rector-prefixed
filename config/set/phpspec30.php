<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperf18a0c41e2d2\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperf18a0c41e2d2\\PhpSpec\\Console\\IO' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Console\\ConsoleIO', '_PhpScoperf18a0c41e2d2\\PhpSpec\\IO\\IOInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\IO\\IO', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Locator\\Resource', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoperf18a0c41e2d2\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Extension', '_PhpScoperf18a0c41e2d2\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoperf18a0c41e2d2\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoperf18a0c41e2d2\\Phpspec\\Event\\EventInterface' => '_PhpScoperf18a0c41e2d2\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Matcher\\Matcher', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoperf18a0c41e2d2\\PhpSpec\\SpecificationInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Specification', '_PhpScoperf18a0c41e2d2\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoperf18a0c41e2d2\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
