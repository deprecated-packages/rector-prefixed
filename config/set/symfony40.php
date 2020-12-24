<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\FormIsValidRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use _PhpScopere8e811afab72\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => '_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', '_PhpScopere8e811afab72\\Symfony\\Component\\Process\\ProcessBuilder' => '_PhpScopere8e811afab72\\Symfony\\Component\\Process\\Process']]]);
};
