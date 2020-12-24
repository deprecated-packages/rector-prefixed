<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameAnnotation;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/phpunit-exception.php');
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\ClassMethod\RenameAnnotationRector::RENAMED_ANNOTATIONS_IN_TYPES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameAnnotation('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase', 'scenario', 'test')])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_\RemoveDataProviderTestPrefixRector::class);
};
