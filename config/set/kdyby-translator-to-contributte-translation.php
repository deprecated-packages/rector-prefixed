<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper5b8c9e9ebd21\\Kdyby\\Translation\\Translator' => '_PhpScoper5b8c9e9ebd21\\Nette\\Localization\\ITranslator', '_PhpScoper5b8c9e9ebd21\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper5b8c9e9ebd21\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper5b8c9e9ebd21\\Kdyby\\Translation\\Phrase' => '_PhpScoper5b8c9e9ebd21\\Contributte\\Translation\\Wrappers\\Message']]]);
};
