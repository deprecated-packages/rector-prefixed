<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperabd03f0baf05\\Kdyby\\Translation\\Translator' => '_PhpScoperabd03f0baf05\\Nette\\Localization\\ITranslator', '_PhpScoperabd03f0baf05\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoperabd03f0baf05\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoperabd03f0baf05\\Kdyby\\Translation\\Phrase' => '_PhpScoperabd03f0baf05\\Contributte\\Translation\\Wrappers\\Message']]]);
};
