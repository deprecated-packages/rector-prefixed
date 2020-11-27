<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper88fe6e0ad041\\Kdyby\\Translation\\Translator' => '_PhpScoper88fe6e0ad041\\Nette\\Localization\\ITranslator', '_PhpScoper88fe6e0ad041\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper88fe6e0ad041\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper88fe6e0ad041\\Kdyby\\Translation\\Phrase' => '_PhpScoper88fe6e0ad041\\Contributte\\Translation\\Wrappers\\Message']]]);
};
