<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperf18a0c41e2d2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperf18a0c41e2d2\\Kdyby\\Translation\\Translator' => '_PhpScoperf18a0c41e2d2\\Nette\\Localization\\ITranslator', '_PhpScoperf18a0c41e2d2\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoperf18a0c41e2d2\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoperf18a0c41e2d2\\Kdyby\\Translation\\Phrase' => '_PhpScoperf18a0c41e2d2\\Contributte\\Translation\\Wrappers\\Message']]]);
};
