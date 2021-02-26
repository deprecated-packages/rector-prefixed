<?php

namespace RectorPrefix20210226;

use Rector\Transform\Rector\ClassMethod\WrapReturnRector;
use Rector\Transform\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass;
use Rector\Transform\ValueObject\WrapReturn;
use RectorPrefix20210226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\ClassMethod\WrapReturnRector::class)->call('configure', [[\Rector\Transform\Rector\ClassMethod\WrapReturnRector::TYPE_METHOD_WRAPS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\WrapReturn(\Rector\Transform\Tests\Rector\ClassMethod\WrapReturnRector\Source\SomeReturnClass::class, 'getItem', \true)])]]);
};
