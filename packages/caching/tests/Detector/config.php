<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Core\Configuration\Option;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::CACHE_DIR, \sys_get_temp_dir() . '/_rector_cached_files_test');
};
