<?php

namespace RectorPrefix20210211;

use Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector;
use Rector\Generic\ValueObject\SwapFuncCallArguments;
use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::class)->call('configure', [[\Rector\Generic\Rector\FuncCall\SwapFuncCallArgumentsRector::FUNCTION_ARGUMENT_SWAPS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\SwapFuncCallArguments('some_function', [1, 0])])]]);
};
