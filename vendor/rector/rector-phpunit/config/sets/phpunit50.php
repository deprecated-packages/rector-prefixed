<?php

declare(strict_types=1);

use Rector\PHPUnit\Rector\StaticCall\GetMockRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();

    $services->set(GetMockRector::class);
};
