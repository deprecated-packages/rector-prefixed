<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper50d83356d739\\Kdyby\\Translation\\Translator' => '_PhpScoper50d83356d739\\Nette\\Localization\\ITranslator', '_PhpScoper50d83356d739\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper50d83356d739\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper50d83356d739\\Kdyby\\Translation\\Phrase' => '_PhpScoper50d83356d739\\Contributte\\Translation\\Wrappers\\Message']]]);
};
