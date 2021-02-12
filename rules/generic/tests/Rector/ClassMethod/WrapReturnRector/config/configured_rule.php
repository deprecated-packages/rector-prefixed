<?php

namespace RectorPrefix20210212;

use Rector\Generic\Rector\ClassMethod\WrapReturnRector;
use Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass;
use Rector\Generic\ValueObject\WrapReturn;
use RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\WrapReturnRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\WrapReturnRector::TYPE_METHOD_WRAPS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\WrapReturn(\Rector\Generic\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass::class, 'getItem', \true)])]]);
};
