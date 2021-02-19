<?php

declare (strict_types=1);
namespace RectorPrefix20210219;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Php73\Rector\BooleanOr\IsCountableRector;
use RectorPrefix20210219\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210219\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE - 1);
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php73\Rector\BooleanOr\IsCountableRector::class);
};
