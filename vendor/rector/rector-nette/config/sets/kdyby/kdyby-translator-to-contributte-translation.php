<?php

declare (strict_types=1);
namespace RectorPrefix20210320;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210320\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20210320\\Kdyby\\Translation\\Translator' => 'RectorPrefix20210320\\Nette\\Localization\\ITranslator', 'RectorPrefix20210320\\Kdyby\\Translation\\DI\\ITranslationProvider' => 'RectorPrefix20210320\\Contributte\\Translation\\DI\\TranslationProviderInterface', 'RectorPrefix20210320\\Kdyby\\Translation\\Phrase' => 'RectorPrefix20210320\\Contributte\\Translation\\Wrappers\\Message']]]);
};
