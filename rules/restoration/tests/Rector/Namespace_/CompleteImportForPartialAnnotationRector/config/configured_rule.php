<?php

namespace RectorPrefix20210212;

use Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector;
use Rector\Restoration\ValueObject\CompleteImportForPartialAnnotation;
use RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210212\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::class)->call('configure', [[\Rector\Restoration\Rector\Namespace_\CompleteImportForPartialAnnotationRector::USE_IMPORTS_TO_RESTORE => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Restoration\ValueObject\CompleteImportForPartialAnnotation('Doctrine\\ORM\\Mapping', 'ORM')])]]);
};
