<?php

namespace RectorPrefix20210209;

use RectorPrefix20210209\JMS\DiExtraBundle\Annotation\Inject;
use Rector\Generic\Rector\Property\InjectAnnotationClassRector;
use RectorPrefix20210209\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210209\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\Property\InjectAnnotationClassRector::class)->call('configure', [[\Rector\Generic\Rector\Property\InjectAnnotationClassRector::ANNOTATION_CLASSES => [\RectorPrefix20210209\JMS\DiExtraBundle\Annotation\Inject::class, \RectorPrefix20210209\DI\Annotation\Inject::class]]]);
};
