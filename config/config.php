<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Core\Configuration\Option;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\ProjectType;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../packages/*/config/config.php');
    $containerConfigurator->import(__DIR__ . '/../rules/*/config/config.php');
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/../utils/*/config/config.php', null, \true);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::PATHS, []);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::FILE_EXTENSIONS, ['php']);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTOLOAD_PATHS, []);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \false);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES, \true);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \true);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, null);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::PROJECT_TYPE, \_PhpScopere8e811afab72\Rector\Core\ValueObject\ProjectType::PROPRIETARY);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::NESTED_CHAIN_METHOD_CALL_LIMIT, 30);
    $parameters->set(\_PhpScopere8e811afab72\Rector\Core\Configuration\Option::SKIP, []);
};
