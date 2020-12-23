<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a2ac50786fa\\PhpSpec\\Console\\IO' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper0a2ac50786fa\\PhpSpec\\IO\\IOInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\IO\\IO', '_PhpScoper0a2ac50786fa\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Locator\\Resource', '_PhpScoper0a2ac50786fa\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper0a2ac50786fa\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper0a2ac50786fa\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper0a2ac50786fa\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Extension', '_PhpScoper0a2ac50786fa\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper0a2ac50786fa\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper0a2ac50786fa\\Phpspec\\Event\\EventInterface' => '_PhpScoper0a2ac50786fa\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper0a2ac50786fa\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper0a2ac50786fa\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Matcher\\Matcher', '_PhpScoper0a2ac50786fa\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper0a2ac50786fa\\PhpSpec\\SpecificationInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Specification', '_PhpScoper0a2ac50786fa\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper0a2ac50786fa\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
