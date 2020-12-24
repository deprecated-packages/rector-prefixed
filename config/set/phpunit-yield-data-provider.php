<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'provide*'), new \_PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'dataProvider*')])]]);
};
