<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector;
use _PhpScoperb75b35f52b74\Rector\Symfony\Rector\Class_\MakeCommandLazyRector;
use _PhpScoperb75b35f52b74\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony\Rector\BinaryOp\ResponseStatusCodeRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony\Rector\Class_\MakeCommandLazyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\SymfonyCodeQuality\Rector\Class_\EventListenerToEventSubscriberRector::class);
};
