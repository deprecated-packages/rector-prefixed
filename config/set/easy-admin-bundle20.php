<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# https://github.com/EasyCorp/EasyAdminBundle/blob/master/UPGRADE-2.0.md
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # first replace ->get("...") by constructor injection in every child of "EasyCorp\Bundle\EasyAdminBundle\AdminController"
    $services->set(\_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::GET_METHOD_AWARE_TYPES => ['_PhpScopere8e811afab72\\EasyCorp\\Bundle\\EasyAdminBundle\\AdminController']]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # then rename the "EasyCorp\Bundle\EasyAdminBundle\AdminController" class
        '_PhpScopere8e811afab72\\EasyCorp\\Bundle\\EasyAdminBundle\\AdminController' => '_PhpScopere8e811afab72\\EasyCorp\\Bundle\\EasyAdminBundle\\EasyAdminController',
    ]]]);
};
