<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector;
use _PhpScoperb75b35f52b74\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector;
use _PhpScoperb75b35f52b74\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector;
use _PhpScoperb75b35f52b74\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use _PhpScoperb75b35f52b74\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector;
use _PhpScoperb75b35f52b74\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Privatization\Rector\Property\PrivatizeLocalPropertyToPrivatePropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Privatization\Rector\ClassConst\PrivatizeLocalClassConstantRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Privatization\Rector\Property\PrivatizeFinalClassPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Privatization\Rector\ClassMethod\PrivatizeFinalClassMethodRector::class);
};
