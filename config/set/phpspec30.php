<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper8b9c402c5f32\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper8b9c402c5f32\\PhpSpec\\Console\\IO' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper8b9c402c5f32\\PhpSpec\\IO\\IOInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\IO\\IO', '_PhpScoper8b9c402c5f32\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Locator\\Resource', '_PhpScoper8b9c402c5f32\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper8b9c402c5f32\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper8b9c402c5f32\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper8b9c402c5f32\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Extension', '_PhpScoper8b9c402c5f32\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper8b9c402c5f32\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper8b9c402c5f32\\Phpspec\\Event\\EventInterface' => '_PhpScoper8b9c402c5f32\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper8b9c402c5f32\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper8b9c402c5f32\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Matcher\\Matcher', '_PhpScoper8b9c402c5f32\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper8b9c402c5f32\\PhpSpec\\SpecificationInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Specification', '_PhpScoper8b9c402c5f32\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper8b9c402c5f32\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
