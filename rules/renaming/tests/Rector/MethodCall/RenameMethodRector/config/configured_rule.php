<?php

namespace RectorPrefix20210213;

use RectorPrefix20210213\Nette\Utils\Html;
use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \Rector\Renaming\ValueObject\MethodCallRename(\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType::class, 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename(\RectorPrefix20210213\Nette\Utils\Html::class, 'add', 'addHtml'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Rector\\Renaming\\Tests\\Rector\\MethodCall\\RenameMethodRector\\Fixture\\DemoFile', 'notify', '__invoke'),
        new \Rector\Renaming\ValueObject\MethodCallRename('*Presenter', 'run', '__invoke'),
        new \Rector\Renaming\ValueObject\MethodCallRename(\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Fixture\SkipSelfMethodRename::class, 'preventPHPStormRefactoring', 'gone'),
        // with array key
        new \Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey(\RectorPrefix20210213\Nette\Utils\Html::class, 'addToArray', 'addToHtmlArray', 'hey'),
    ])]]);
};
