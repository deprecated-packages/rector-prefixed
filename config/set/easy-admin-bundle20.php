<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector;
use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
# https://github.com/EasyCorp/EasyAdminBundle/blob/master/UPGRADE-2.0.md
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    # first replace ->get("...") by constructor injection in every child of "EasyCorp\Bundle\EasyAdminBundle\AdminController"
    $services->set(\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::class)->call('configure', [[\Rector\Symfony\Rector\MethodCall\GetToConstructorInjectionRector::GET_METHOD_AWARE_TYPES => ['RectorPrefix20201228\\EasyCorp\\Bundle\\EasyAdminBundle\\AdminController']]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        # then rename the "EasyCorp\Bundle\EasyAdminBundle\AdminController" class
        'RectorPrefix20201228\\EasyCorp\\Bundle\\EasyAdminBundle\\AdminController' => 'RectorPrefix20201228\\EasyCorp\\Bundle\\EasyAdminBundle\\EasyAdminController',
    ]]]);
};
