<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\FormIsValidRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector;
use _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\ConstFetch\ConstraintUrlOptionRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\FormIsValidRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\VarDumperTestTraitMethodArgsRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ContainerBuilderCompileEnvArgumentRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\StaticCall\ProcessBuilderInstanceRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Symfony4\Rector\MethodCall\ProcessBuilderGetProcessRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Tests\\Constraints\\AbstractConstraintValidatorTest' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Test\\ConstraintValidatorTestCase', '_PhpScoperb75b35f52b74\\Symfony\\Component\\Process\\ProcessBuilder' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Process\\Process']]]);
};
