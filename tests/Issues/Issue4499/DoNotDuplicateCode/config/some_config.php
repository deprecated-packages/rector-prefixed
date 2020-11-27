<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Rector\Php74\Rector\Property\TypedPropertyRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    // put anything here
    $services->set(\Rector\Php74\Rector\Property\TypedPropertyRector::class);
};
