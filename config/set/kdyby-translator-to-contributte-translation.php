<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperbf340cb0be9d\\Kdyby\\Translation\\Translator' => '_PhpScoperbf340cb0be9d\\Nette\\Localization\\ITranslator', '_PhpScoperbf340cb0be9d\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoperbf340cb0be9d\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoperbf340cb0be9d\\Kdyby\\Translation\\Phrase' => '_PhpScoperbf340cb0be9d\\Contributte\\Translation\\Wrappers\\Message']]]);
};
