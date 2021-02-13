<?php

namespace RectorPrefix20210213;

use Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector;
use Rector\Removing\ValueObject\RemoveFuncCallArg;
use RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210213\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector::class)->call('configure', [[\Rector\Removing\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Removing\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2)])]]);
};
