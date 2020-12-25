<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper50d83356d739\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper50d83356d739\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper50d83356d739\\PhpSpec\\Console\\IO' => '_PhpScoper50d83356d739\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper50d83356d739\\PhpSpec\\IO\\IOInterface' => '_PhpScoper50d83356d739\\PhpSpec\\IO\\IO', '_PhpScoper50d83356d739\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Locator\\Resource', '_PhpScoper50d83356d739\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper50d83356d739\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper50d83356d739\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper50d83356d739\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper50d83356d739\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Extension', '_PhpScoper50d83356d739\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper50d83356d739\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper50d83356d739\\Phpspec\\Event\\EventInterface' => '_PhpScoper50d83356d739\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper50d83356d739\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper50d83356d739\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Matcher\\Matcher', '_PhpScoper50d83356d739\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper50d83356d739\\PhpSpec\\SpecificationInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Specification', '_PhpScoper50d83356d739\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper50d83356d739\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
