<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \_PhpScoper0a6b37af0871\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase', 'provide*'), new \_PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase', 'dataProvider*')])]]);
};
