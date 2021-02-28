<?php

declare (strict_types=1);
namespace RectorPrefix20210228;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use RectorPrefix20210228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        new \Rector\Renaming\ValueObject\MethodCallRename(\Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\Source\AbstractType::class, 'setDefaultOptions', 'configureOptions'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Nette\\Utils\\Html', 'add', 'addHtml'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Rector\\Renaming\\Tests\\Rector\\MethodCall\\RenameMethodRector\\Fixture\\DemoFile', 'notify', '__invoke'),
        new \Rector\Renaming\ValueObject\MethodCallRename('Rector\\Renaming\\Tests\\Rector\\MethodCall\\RenameMethodRector\\Fixture\\SomeSubscriber', 'old', 'new'),
        // with array key
        new \Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey('Nette\\Utils\\Html', 'addToArray', 'addToHtmlArray', 'hey'),
    ])]]);
};
