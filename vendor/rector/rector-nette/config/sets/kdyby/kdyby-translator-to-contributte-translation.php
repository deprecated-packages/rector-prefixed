<?php

declare (strict_types=1);
namespace RectorPrefix20210321;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210321\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['RectorPrefix20210321\\Kdyby\\Translation\\Translator' => 'RectorPrefix20210321\\Nette\\Localization\\ITranslator', 'RectorPrefix20210321\\Kdyby\\Translation\\DI\\ITranslationProvider' => 'RectorPrefix20210321\\Contributte\\Translation\\DI\\TranslationProviderInterface', 'RectorPrefix20210321\\Kdyby\\Translation\\Phrase' => 'RectorPrefix20210321\\Contributte\\Translation\\Wrappers\\Message']]]);
};
