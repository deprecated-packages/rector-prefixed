<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use Rector\Symfony4\Rector\MethodCall\FormIsValidRector;
use Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector;
use Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Process\\ProcessBuilder' => '_PhpScoperbf340cb0be9d\\Symfony\\Component\\Process\\Process']]]);
};
