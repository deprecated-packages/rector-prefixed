<?php

namespace RectorPrefix20210319;

use Rector\PHPUnit\Rector\Class_\ArrayArgumentToDataProviderRector;
use Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../config/config.php');
    $services = $containerConfigurator->services();
    $services->set(\Rector\PHPUnit\Rector\Class_\ArrayArgumentToDataProviderRector::class)->call('configure', [[\Rector\PHPUnit\Rector\Class_\ArrayArgumentToDataProviderRector::ARRAY_ARGUMENTS_TO_DATA_PROVIDERS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\PHPUnit\ValueObject\ArrayArgumentToDataProvider('RectorPrefix20210319\\PHPUnit\\Framework\\TestCase', 'doTestMultiple', 'doTestSingle', 'variable')])]]);
};
