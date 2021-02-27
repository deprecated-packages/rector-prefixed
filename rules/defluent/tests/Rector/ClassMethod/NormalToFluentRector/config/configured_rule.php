<?php

namespace RectorPrefix20210227;

use Rector\Defluent\Rector\ClassMethod\NormalToFluentRector;
use Rector\Defluent\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass;
use Rector\Defluent\ValueObject\NormalToFluent;
use RectorPrefix20210227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Defluent\Rector\ClassMethod\NormalToFluentRector::class)->call('configure', [[\Rector\Defluent\Rector\ClassMethod\NormalToFluentRector::CALLS_TO_FLUENT => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Defluent\ValueObject\NormalToFluent(\Rector\Defluent\Tests\Rector\ClassMethod\NormalToFluentRector\Source\FluentInterfaceClass::class, ['someFunction', 'otherFunction', 'joinThisAsWell'])])]]);
};
