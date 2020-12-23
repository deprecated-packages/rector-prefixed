<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector;
use _PhpScoper0a2ac50786fa\Rector\MockistaToMockery\Rector\ClassMethod\MockistaMockToMockeryMockRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector::class);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\MockistaToMockery\Rector\ClassMethod\MockistaMockToMockeryMockRector::class);
};
