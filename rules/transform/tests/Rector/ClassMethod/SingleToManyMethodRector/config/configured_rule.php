<?php

namespace RectorPrefix20210225;

use Rector\Transform\Rector\ClassMethod\SingleToManyMethodRector;
use Rector\Transform\Tests\Rector\ClassMethod\SingleToManyMethodRector\Source\OneToManyInterface;
use Rector\Transform\ValueObject\SingleToManyMethod;
use RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\ClassMethod\SingleToManyMethodRector::class)->call('configure', [[\Rector\Transform\Rector\ClassMethod\SingleToManyMethodRector::SINGLES_TO_MANY_METHODS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\SingleToManyMethod(\Rector\Transform\Tests\Rector\ClassMethod\SingleToManyMethodRector\Source\OneToManyInterface::class, 'getNode', 'getNodes')])]]);
};
