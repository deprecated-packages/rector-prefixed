<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\FormIsValidRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Process\\ProcessBuilder' => '_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\Process\\Process']]]);
};
