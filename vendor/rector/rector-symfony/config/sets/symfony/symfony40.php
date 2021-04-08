<?php

declare (strict_types=1);
namespace RectorPrefix20210408;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Symfony\Rector\ConstFetch\ConstraintUrlOptionRector;
use Rector\Symfony\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use Rector\Symfony\Rector\MethodCall\FormIsValidRector;
use Rector\Symfony\Rector\MethodCall\ProcessBuilderGetProcessRector;
use Rector\Symfony\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use Rector\Symfony\Rector\StaticCall\ProcessBuilderInstanceRector;
use RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210408\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Symfony\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\Rector\Symfony\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\Rector\Symfony\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => 'Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', 'Symfony\\Component\\Process\\ProcessBuilder' => 'Symfony\\Component\\Process\\Process']]]);
};
