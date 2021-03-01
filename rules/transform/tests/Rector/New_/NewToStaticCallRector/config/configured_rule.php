<?php

namespace RectorPrefix20210301;

use Rector\Transform\Rector\New_\NewToStaticCallRector;
use Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass;
use Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass;
use Rector\Transform\ValueObject\NewToStaticCall;
use RectorPrefix20210301\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210301\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\New_\NewToStaticCallRector::class)->call('configure', [[\Rector\Transform\Rector\New_\NewToStaticCallRector::TYPE_TO_STATIC_CALLS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\NewToStaticCall(\Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\FromNewClass::class, \Rector\Transform\Tests\Rector\New_\NewToStaticCallRector\Source\IntoStaticClass::class, 'run')])]]);
};
