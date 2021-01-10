<?php

declare (strict_types=1);
namespace RectorPrefix20210110;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use Rector\Symfony4\Rector\MethodCall\FormIsValidRector;
use Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector;
use Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector;
use RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210110\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => 'Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', 'Symfony\\Component\\Process\\ProcessBuilder' => 'Symfony\\Component\\Process\\Process']]]);
};
