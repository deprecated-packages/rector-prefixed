<?php

namespace RectorPrefix20210228;

use Rector\Arguments\NodeAnalyzer\ArgumentAddingScope;
use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Arguments\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder;
use Rector\Arguments\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient;
use Rector\Arguments\ValueObject\ArgumentAdder;
use RectorPrefix20210228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // covers https://github.com/rectorphp/rector/issues/4267
        new \Rector\Arguments\ValueObject\ArgumentAdder(\Rector\Arguments\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'sendResetLinkResponse', 0, 'request', null, 'Illuminate\\Http\\Illuminate\\Http'),
        new \Rector\Arguments\ValueObject\ArgumentAdder(\Rector\Arguments\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'compile', 0, 'isCompiled', \false),
        new \Rector\Arguments\ValueObject\ArgumentAdder(\Rector\Arguments\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeContainerBuilder::class, 'addCompilerPass', 2, 'priority', 0, 'int'),
        // scoped
        new \Rector\Arguments\ValueObject\ArgumentAdder(\Rector\Arguments\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \Rector\Arguments\NodeAnalyzer\ArgumentAddingScope::SCOPE_PARENT_CALL),
        new \Rector\Arguments\ValueObject\ArgumentAdder(\Rector\Arguments\Tests\Rector\ClassMethod\ArgumentAdderRector\Source\SomeParentClient::class, 'submit', 2, 'serverParameters', [], 'array', \Rector\Arguments\NodeAnalyzer\ArgumentAddingScope::SCOPE_CLASS_METHOD),
    ])]]);
};
