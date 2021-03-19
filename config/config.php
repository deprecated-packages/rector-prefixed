<?php

declare (strict_types=1);
namespace RectorPrefix20210319;

use Rector\Core\Configuration\Option;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/services-rules.php');
    $containerConfigurator->import(__DIR__ . '/services-packages.php');
    $containerConfigurator->import(__DIR__ . '/parameters.php');
    // rector root
    $containerConfigurator->import(__DIR__ . '/../vendor/rector/rector-symfony/config/config.php', null, 'not_found');
    $containerConfigurator->import(__DIR__ . '/../vendor/rector/rector-nette/config/config.php', null, 'not_found');
    $containerConfigurator->import(__DIR__ . '/../vendor/rector/rector-laravel/config/config.php', null, 'not_found');
    // rector sub-package
    $containerConfigurator->import(__DIR__ . '/../../rector-symfony/config/config.php', null, 'not_found');
    $containerConfigurator->import(__DIR__ . '/../../rector-nette/config/config.php', null, 'not_found');
    $containerConfigurator->import(__DIR__ . '/../../rector-laravel/config/config.php', null, 'not_found');
    // require only in dev
    $containerConfigurator->import(__DIR__ . '/../utils/compiler/config/config.php', null, 'not_found');
    // to override extension-loaded config
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHPSTAN_FOR_RECTOR_PATH, \getcwd() . '/phpstan-for-rector.neon');
};
