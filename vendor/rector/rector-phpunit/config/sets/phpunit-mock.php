<?php

declare(strict_types=1);

use Rector\PHPUnit\Rector\MethodCall\UseSpecificWillMethodRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(UseSpecificWillMethodRector::class);
};
