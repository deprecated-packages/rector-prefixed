<?php

declare (strict_types=1);
namespace RectorPrefix20210215;

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use RectorPrefix20210215\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210215\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SETS, [\Rector\Set\ValueObject\SetList::DOCTRINE_REPOSITORY_AS_SERVICE]);
};
