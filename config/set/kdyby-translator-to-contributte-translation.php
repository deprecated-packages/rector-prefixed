<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper8b9c402c5f32\\Kdyby\\Translation\\Translator' => '_PhpScoper8b9c402c5f32\\Nette\\Localization\\ITranslator', '_PhpScoper8b9c402c5f32\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper8b9c402c5f32\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper8b9c402c5f32\\Kdyby\\Translation\\Phrase' => '_PhpScoper8b9c402c5f32\\Contributte\\Translation\\Wrappers\\Message']]]);
};
