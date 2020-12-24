<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector;
use _PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# see: https://gnugat.github.io/2015/09/23/phpunit-with-phpspec.html
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # 1. first convert mocks
    $services->set(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecMocksToPHPUnitMocksRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\MethodCall\PhpSpecPromisesToPHPUnitAssertRector::class);
    # 2. then methods
    $services->set(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\ClassMethod\PhpSpecMethodToPHPUnitMethodRector::class);
    # 3. then the class itself
    $services->set(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\PhpSpecClassToPHPUnitClassRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Class_\AddMockPropertiesRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\Variable\MockVariableToPropertyFetchRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector::class);
};
