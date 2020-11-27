<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\DowngradeSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PATHS, [__DIR__ . '/vendor/phpstan/phpstan-src/src']);
    $parameters->set(\Rector\Core\Configuration\Option::SETS, [\Rector\Set\ValueObject\DowngradeSetList::PHP_74]);
};
