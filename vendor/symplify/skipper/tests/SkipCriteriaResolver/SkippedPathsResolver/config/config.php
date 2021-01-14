<?php

declare (strict_types=1);
namespace RectorPrefix20210114;

use RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210114\Symplify\Skipper\ValueObject\Option;
return static function (\RectorPrefix20210114\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\RectorPrefix20210114\Symplify\Skipper\ValueObject\Option::SKIP, [
        // windows slashes
        __DIR__ . '\\non-existing-path',
        __DIR__ . '/../Fixture',
        '*\\Mask\\*',
    ]);
};
