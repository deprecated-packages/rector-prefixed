<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Generic\ValueObject\ArgumentRemover;
use Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentRemover('RectorPrefix2020DecSat\\Symfony\\Component\\Yaml\\Yaml', 'parse', 2, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS'])])]]);
    $services->set(\Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector::class);
};
