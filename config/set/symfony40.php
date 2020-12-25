<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use Rector\Symfony4\Rector\MethodCall\FormIsValidRector;
use Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector;
use Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Process\\ProcessBuilder' => '_PhpScoper8b9c402c5f32\\Symfony\\Component\\Process\\Process']]]);
};
