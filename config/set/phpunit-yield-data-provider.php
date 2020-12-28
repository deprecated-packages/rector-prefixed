<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201228\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \RectorPrefix20201228\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('RectorPrefix20201228\\PHPUnit\\Framework\\TestCase', 'provide*'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('RectorPrefix20201228\\PHPUnit\\Framework\\TestCase', 'dataProvider*')])]]);
};
