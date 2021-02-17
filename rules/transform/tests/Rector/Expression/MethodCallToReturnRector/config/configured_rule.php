<?php

namespace RectorPrefix20210217;

use Rector\Transform\Rector\Expression\MethodCallToReturnRector;
use Rector\Transform\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny;
use Rector\Transform\ValueObject\MethodCallToReturn;
use RectorPrefix20210217\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210217\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Expression\MethodCallToReturnRector::class)->call('configure', [[\Rector\Transform\Rector\Expression\MethodCallToReturnRector::METHOD_CALL_WRAPS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\MethodCallToReturn(\Rector\Transform\Tests\Rector\Expression\MethodCallToReturnRector\Source\ReturnDeny::class, 'deny')])]]);
};
