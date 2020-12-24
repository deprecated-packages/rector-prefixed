<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // @see http://www.phpspec.net/en/stable/manual/upgrading-to-phpspec-3.html
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\PhpSpec\\ServiceContainer', 'set', 'define'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\PhpSpec\\ServiceContainer', 'setShared', 'define'),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\PhpSpec\\Console\\IO' => '_PhpScoperb75b35f52b74\\PhpSpec\\Console\\ConsoleIO', '_PhpScoperb75b35f52b74\\PhpSpec\\IO\\IOInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\IO\\IO', '_PhpScoperb75b35f52b74\\PhpSpec\\Locator\\ResourceInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Locator\\Resource', '_PhpScoperb75b35f52b74\\PhpSpec\\Locator\\ResourceLocatorInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Locator\\ResourceLocator', '_PhpScoperb75b35f52b74\\PhpSpec\\Formatter\\Presenter\\PresenterInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Formatter\\Presenter\\Presenter', '_PhpScoperb75b35f52b74\\PhpSpec\\CodeGenerator\\Generator\\GeneratorInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\CodeGenerator\\Generator\\Generator', '_PhpScoperb75b35f52b74\\PhpSpec\\Extension\\ExtensionInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Extension', '_PhpScoperb75b35f52b74\\Phpspec\\CodeAnalysis\\AccessInspectorInterface' => '_PhpScoperb75b35f52b74\\Phpspec\\CodeAnalysis\\AccessInspector', '_PhpScoperb75b35f52b74\\Phpspec\\Event\\EventInterface' => '_PhpScoperb75b35f52b74\\Phpspec\\Event\\PhpSpecEvent', '_PhpScoperb75b35f52b74\\PhpSpec\\Formatter\\Presenter\\Differ\\EngineInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Formatter\\Presenter\\Differ\\DifferEngine', '_PhpScoperb75b35f52b74\\PhpSpec\\Matcher\\MatcherInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Matcher\\Matcher', '_PhpScoperb75b35f52b74\\PhpSpec\\Matcher\\MatchersProviderInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Matcher\\MatchersProvider', '_PhpScoperb75b35f52b74\\PhpSpec\\SpecificationInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Specification', '_PhpScoperb75b35f52b74\\PhpSpec\\Runner\\Maintainer\\MaintainerInterface' => '_PhpScoperb75b35f52b74\\PhpSpec\\Runner\\Maintainer\\Maintainer']]]);
};
