<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use Rector\Generic\ValueObject\ArgumentRemover;
use Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Generic\ValueObject\ArgumentRemover('_PhpScoper8b9c402c5f32\\Symfony\\Component\\Yaml\\Yaml', 'parse', 2, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS'])])]]);
    $services->set(\Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector::class);
};
