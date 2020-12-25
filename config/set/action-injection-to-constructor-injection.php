<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Generic\Rector\Class_\ActionInjectionToConstructorInjectionRector;
use Rector\Generic\Rector\Variable\ReplaceVariableByPropertyFetchRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Class_\ActionInjectionToConstructorInjectionRector::class);
    $services->set(\Rector\Generic\Rector\Variable\ReplaceVariableByPropertyFetchRector::class);
};
