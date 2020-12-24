<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\ProjectType;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../packages/*/config/config.php');
    $containerConfigurator->import(__DIR__ . '/../rules/*/config/config.php');
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/../utils/*/config/config.php', null, \true);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::PATHS, []);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::FILE_EXTENSIONS, ['php']);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::AUTOLOAD_PATHS, []);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES, \true);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, null);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::PROJECT_TYPE, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\ProjectType::PROPRIETARY);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::NESTED_CHAIN_METHOD_CALL_LIMIT, 30);
    $parameters->set(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::SKIP, []);
};
