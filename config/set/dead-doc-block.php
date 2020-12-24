<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessParamTagRector;
use _PhpScoperb75b35f52b74\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessParamTagRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\DeadDocBlock\Rector\ClassMethod\RemoveUselessReturnTagRector::class);
};