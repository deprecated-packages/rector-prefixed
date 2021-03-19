<?php

namespace RectorPrefix20210319;

use Rector\Core\Configuration\Option;
use Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use Rector\Tests\Symfony\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait;
use Rector\Tests\Symfony\Rector\Source\SymfonyController;
use RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210319\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/config.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/../xml/services.xml');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class)->call('configure', [[\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::GET_METHOD_AWARE_TYPES => [\Rector\Tests\Symfony\Rector\Source\SymfonyController::class, \Rector\Tests\Symfony\Rector\MethodCall\GetToConstructorInjectionRector\Source\GetTrait::class]]]);
};
