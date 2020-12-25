<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Generic\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Generic\ValueObject\ArgumentAdder;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentAdderRector::ADDED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentAdder('_PhpScoperbf340cb0be9d\\Symfony\\Component\\DependencyInjection\\ContainerBuilder', 'addCompilerPass', 2, 'priority', '0')])]]);
};
