<?php

declare (strict_types=1);
namespace RectorPrefix20201226;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20201226\\Kdyby\\Translation\\Translator' => 'RectorPrefix20201226\\Nette\\Localization\\ITranslator', 'RectorPrefix20201226\\Kdyby\\Translation\\DI\\ITranslationProvider' => 'RectorPrefix20201226\\Contributte\\Translation\\DI\\TranslationProviderInterface', 'RectorPrefix20201226\\Kdyby\\Translation\\Phrase' => 'RectorPrefix20201226\\Contributte\\Translation\\Wrappers\\Message']]]);
};
