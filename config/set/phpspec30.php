<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper26e51eeacccf\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper26e51eeacccf\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper26e51eeacccf\\PhpSpec\\Console\\IO' => '_PhpScoper26e51eeacccf\\PhpSpec\\Console\\ConsoleIO', '_PhpScoper26e51eeacccf\\PhpSpec\\IO\\IOInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\IO\\IO', '_PhpScoper26e51eeacccf\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Locator\\Resource', '_PhpScoper26e51eeacccf\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoper26e51eeacccf\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoper26e51eeacccf\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoper26e51eeacccf\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Extension', '_PhpScoper26e51eeacccf\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoper26e51eeacccf\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoper26e51eeacccf\\Phpspec\\Event\\EventInterface' => '_PhpScoper26e51eeacccf\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoper26e51eeacccf\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoper26e51eeacccf\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Matcher\\Matcher', '_PhpScoper26e51eeacccf\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoper26e51eeacccf\\PhpSpec\\SpecificationInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Specification', '_PhpScoper26e51eeacccf\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoper26e51eeacccf\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
