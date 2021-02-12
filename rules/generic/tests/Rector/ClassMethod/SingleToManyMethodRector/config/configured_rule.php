<?php

namespace RectorPrefix20210212;

use Rector\Generic\Rector\ClassMethod\SingleToManyMethodRector;
use Rector\Generic\Tests\Rector\ClassMethod\SingleToManyMethodRector\Source\OneToManyInterface;
use Rector\Generic\ValueObject\SingleToManyMethod;
use RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\SingleToManyMethodRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\SingleToManyMethodRector::SINGLES_TO_MANY_METHODS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\SingleToManyMethod(\Rector\Generic\Tests\Rector\ClassMethod\SingleToManyMethodRector\Source\OneToManyInterface::class, 'getNode', 'getNodes')])]]);
};
