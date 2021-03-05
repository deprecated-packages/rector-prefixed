<?php

declare (strict_types=1);
namespace RectorPrefix20210305;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use RectorPrefix20210305\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210305\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersionFeature::UNION_TYPES - 1);
    $services = $containerConfigurator->services();
    $services->set(\Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector::class);
};
