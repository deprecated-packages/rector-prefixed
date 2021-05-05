<?php

declare (strict_types=1);
namespace RectorPrefix20210505;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use RectorPrefix20210505\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210505\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersion::PHP_53);
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp53\Rector\Dir\DirConstToFileConstRector::class);
};
