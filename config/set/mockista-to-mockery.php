<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector;
use _PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\ClassMethod\MockistaMockToMockeryMockRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\ClassMethod\MockistaMockToMockeryMockRector::class);
};
