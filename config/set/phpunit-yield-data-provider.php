<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\TestCase', 'provide*'), new \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\TestCase', 'dataProvider*')])]]);
};
