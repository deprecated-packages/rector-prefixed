<?php

namespace RectorPrefix20210304;

use Rector\Transform\Rector\FuncCall\FuncCallToNewRector;
use RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\FuncCall\FuncCallToNewRector::class)->call('configure', [[\Rector\Transform\Rector\FuncCall\FuncCallToNewRector::FUNCTIONS_TO_NEWS => ['collection' => ['Collection']]]]);
};
