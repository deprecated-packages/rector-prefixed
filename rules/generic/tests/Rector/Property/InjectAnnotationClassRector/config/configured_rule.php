<?php

namespace RectorPrefix20210212;

use RectorPrefix20210212\JMS\DiExtraBundle\Annotation\Inject;
use Rector\Core\Configuration\Option;
use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, __DIR__ . '/../../../../../../symfony/tests/Rector/MethodCall/GetToConstructorInjectionRector/xml/services.xml');
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => [\RectorPrefix20210212\JMS\DiExtraBundle\Annotation\Inject::class, \RectorPrefix20210212\DI\Annotation\Inject::class]]]);
};
