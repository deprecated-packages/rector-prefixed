<?php

namespace RectorPrefix20210211;

use Rector\CodingStyle\Rector\FuncCall\FunctionCallToConstantRector;
use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodingStyle\Rector\FuncCall\FunctionCallToConstantRector::class)->call('configure', [[\Rector\CodingStyle\Rector\FuncCall\FunctionCallToConstantRector::FUNCTIONS_TO_CONSTANTS => ['php_sapi_name' => 'PHP_SAPI', 'pi' => 'M_PI']]]);
};
