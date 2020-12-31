<?php

declare (strict_types=1);
namespace RectorPrefix20201231;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\ProjectType;
use RectorPrefix20201231\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201231\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../packages/*/config/config.php');
    $containerConfigurator->import(__DIR__ . '/../rules/*/config/config.php');
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/../utils/*/config/config.php', null, \true);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PATHS, []);
    $parameters->set(\Rector\Core\Configuration\Option::FILE_EXTENSIONS, ['php']);
    $parameters->set(\Rector\Core\Configuration\Option::AUTOLOAD_PATHS, []);
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
    $parameters->set(\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES, \true);
    $parameters->set(\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, null);
    $parameters->set(\Rector\Core\Configuration\Option::PROJECT_TYPE, \Rector\Core\ValueObject\ProjectType::PROPRIETARY);
    $parameters->set(\Rector\Core\Configuration\Option::NESTED_CHAIN_METHOD_CALL_LIMIT, 30);
    $parameters->set(\Rector\Core\Configuration\Option::SKIP, []);
};
