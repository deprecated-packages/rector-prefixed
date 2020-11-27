<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/rules', __DIR__ . '/utils', __DIR__ . '/packages', __DIR__ . '/bin/rector']);
    $parameters->set(\Rector\Core\Configuration\Option::SKIP, ['/Source/', '/*Source/', '/Fixture/', '/Expected/', __DIR__ . '/packages/doctrine-annotation-generated/src/*', __DIR__ . '/packages/rector-generator/templates/*', '*.php.inc']);
    $parameters->set(\Rector\Core\Configuration\Option::AUTO_IMPORT_NAMES, \true);
    # so Rector code is still PHP 7.2 compatible
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersion::PHP_7_2);
};
