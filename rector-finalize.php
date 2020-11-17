<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::AUTOLOAD_PATHS, [
        __DIR__ . '/fixture-finalize',
    ]);

    $services = $containerConfigurator->services();

    $services->set(FinalizeClassesWithoutChildrenRector::class);
};
