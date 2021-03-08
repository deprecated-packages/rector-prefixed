<?php

namespace RectorPrefix20210308;

use Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToValueRector;
use Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToValueRector\Source\OldClassWithConstants;
use Rector\Transform\ValueObject\ClassConstFetchToValue;
use RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210308\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToValueRector::class)->call('configure', [[\Rector\Transform\Rector\ClassConstFetch\ClassConstFetchToValueRector::CLASS_CONST_FETCHES_TO_VALUES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ClassConstFetchToValue(\Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToValueRector\Source\OldClassWithConstants::class, 'DEVELOPMENT', 'development'), new \Rector\Transform\ValueObject\ClassConstFetchToValue(\Rector\Transform\Tests\Rector\ClassConstFetch\ClassConstFetchToValueRector\Source\OldClassWithConstants::class, 'PRODUCTION', 'production')])]]);
};
