<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix2020DecSat\\Kdyby\\Translation\\Translator' => 'RectorPrefix2020DecSat\\Nette\\Localization\\ITranslator', 'RectorPrefix2020DecSat\\Kdyby\\Translation\\DI\\ITranslationProvider' => 'RectorPrefix2020DecSat\\Contributte\\Translation\\DI\\TranslationProviderInterface', 'RectorPrefix2020DecSat\\Kdyby\\Translation\\Phrase' => 'RectorPrefix2020DecSat\\Contributte\\Translation\\Wrappers\\Message']]]);
};
