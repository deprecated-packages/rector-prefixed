<?php

declare (strict_types=1);
namespace RectorPrefix20210505;

use RectorPrefix20210505\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210505\Symplify\EasyCodingStandard\ValueObject\Option;
use RectorPrefix20210505\Symplify\EasyCodingStandard\ValueObject\Set\SetList;
return static function (\RectorPrefix20210505\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\RectorPrefix20210505\Symplify\EasyCodingStandard\ValueObject\Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);
    $parameters->set(\RectorPrefix20210505\Symplify\EasyCodingStandard\ValueObject\Option::SETS, [\RectorPrefix20210505\Symplify\EasyCodingStandard\ValueObject\Set\SetList::COMMON, \RectorPrefix20210505\Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12]);
};
