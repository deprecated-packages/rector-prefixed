<?php

declare (strict_types=1);
namespace RectorPrefix20210420;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210420\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210420\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['Kdyby\\Translation\\Translator' => 'Nette\\Localization\\ITranslator', 'Kdyby\\Translation\\DI\\ITranslationProvider' => 'Contributte\\Translation\\DI\\TranslationProviderInterface', 'Kdyby\\Translation\\Phrase' => 'Contributte\\Translation\\Wrappers\\Message']]]);
};
