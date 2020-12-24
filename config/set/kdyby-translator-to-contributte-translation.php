<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopere8e811afab72\\Kdyby\\Translation\\Translator' => '_PhpScopere8e811afab72\\Nette\\Localization\\ITranslator', '_PhpScopere8e811afab72\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScopere8e811afab72\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScopere8e811afab72\\Kdyby\\Translation\\Phrase' => '_PhpScopere8e811afab72\\Contributte\\Translation\\Wrappers\\Message']]]);
};
