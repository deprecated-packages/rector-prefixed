<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\Class_\NetteTesterClassToPHPUnitClassRector;
use _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector;
use _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\StaticCall\NetteAssertToPHPUnitAssertRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\Class_\NetteTesterClassToPHPUnitClassRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\StaticCall\NetteAssertToPHPUnitAssertRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector::class);
};
