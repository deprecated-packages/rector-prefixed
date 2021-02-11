<?php

declare (strict_types=1);
namespace RectorPrefix20210211;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeReturnDeclarationRector;
use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersionFeature::NULLABLE_TYPE - 1);
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeReturnDeclarationRector::class);
};
