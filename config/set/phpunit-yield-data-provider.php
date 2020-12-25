<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726;

use Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper17db12703726\\PHPUnit\\Framework\\TestCase', 'provide*'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoper17db12703726\\PHPUnit\\Framework\\TestCase', 'dataProvider*')])]]);
};
