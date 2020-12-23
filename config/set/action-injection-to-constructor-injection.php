<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\ActionInjectionToConstructorInjectionRector;
use _PhpScoper0a2ac50786fa\Rector\Generic\Rector\Variable\ReplaceVariableByPropertyFetchRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\Class_\ActionInjectionToConstructorInjectionRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Generic\Rector\Variable\ReplaceVariableByPropertyFetchRector::class);
};
