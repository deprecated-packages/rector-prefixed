<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'provide*'), new \_PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase', 'dataProvider*')])]]);
};
