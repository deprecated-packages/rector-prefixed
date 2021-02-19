<?php

namespace RectorPrefix20210219;

use RectorPrefix20210219\PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector;
use Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface;
use Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase;
use Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield;
use RectorPrefix20210219\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210219\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::class)->call('configure', [[\Rector\CodingStyle\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector::METHODS_TO_YIELDS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\EventSubscriberInterface::class, 'getSubscribedEvents'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'provide*'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\Rector\CodingStyle\Tests\Rector\ClassMethod\ReturnArrayClassMethodToYieldRector\Source\ParentTestCase::class, 'dataProvider*'), new \Rector\CodingStyle\ValueObject\ReturnArrayClassMethodToYield(\RectorPrefix20210219\PHPUnit\Framework\TestCase::class, 'provideData')])]]);
};
