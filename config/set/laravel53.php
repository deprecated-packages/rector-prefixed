<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\RemoveTraitRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\RemoveTraitRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\Class_\RemoveTraitRector::TRAITS_TO_REMOVE => [
        # see https://laravel.com/docs/5.3/upgrade
        '_PhpScoperb75b35f52b74\\Illuminate\\Foundation\\Auth\\Access\\AuthorizesResources',
    ]]]);
};
