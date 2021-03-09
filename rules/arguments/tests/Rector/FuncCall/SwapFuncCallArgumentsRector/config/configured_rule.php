<?php

namespace RectorPrefix20210309;

use Rector\Arguments\Rector\FuncCall\SwapFuncCallArgumentsRector;
use Rector\Arguments\ValueObject\SwapFuncCallArguments;
use RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210309\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Arguments\Rector\FuncCall\SwapFuncCallArgumentsRector::class)->call('configure', [[\Rector\Arguments\Rector\FuncCall\SwapFuncCallArgumentsRector::FUNCTION_ARGUMENT_SWAPS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Arguments\ValueObject\SwapFuncCallArguments('some_function', [1, 0])])]]);
};
