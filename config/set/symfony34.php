<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover;
use _PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod\ArgumentRemoverRector::REMOVED_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\ArgumentRemover('_PhpScopere8e811afab72\\Symfony\\Component\\Yaml\\Yaml', 'parse', 2, ['Symfony\\Component\\Yaml\\Yaml::PARSE_KEYS_AS_STRINGS'])])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod\MergeMethodAnnotationToRouteAnnotationRector::class);
};
