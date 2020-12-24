<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\FormIsValidRector;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use _PhpScoper0a6b37af0871\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a6b37af0871\\Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', '_PhpScoper0a6b37af0871\\Symfony\\Component\\Process\\ProcessBuilder' => '_PhpScoper0a6b37af0871\\Symfony\\Component\\Process\\Process']]]);
};
