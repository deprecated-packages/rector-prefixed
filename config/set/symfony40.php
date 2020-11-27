<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Symfony\Rector\ConstFetch\ConstraintUrlOptionRector;
use Rector\Symfony\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use Rector\Symfony\Rector\MethodCall\FormIsValidRector;
use Rector\Symfony\Rector\MethodCall\ProcessBuilderGetProcessRector;
use Rector\Symfony\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use Rector\Symfony\Rector\StaticCall\ProcessBuilderInstanceRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\Rector\Symfony\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper006a73f0e455\\Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => '_PhpScoper006a73f0e455\\Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', '_PhpScoper006a73f0e455\\Symfony\\Component\\Process\\ProcessBuilder' => '_PhpScoper006a73f0e455\\Symfony\\Component\\Process\\Process']]]);
};
