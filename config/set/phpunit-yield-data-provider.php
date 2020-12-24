<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'provide*'), new \_PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield('_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\TestCase', 'dataProvider*')])]]);
};
