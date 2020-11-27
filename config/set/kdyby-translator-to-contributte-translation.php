<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper006a73f0e455\\Kdyby\\Translation\\Translator' => '_PhpScoper006a73f0e455\\Nette\\Localization\\ITranslator', '_PhpScoper006a73f0e455\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper006a73f0e455\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper006a73f0e455\\Kdyby\\Translation\\Phrase' => '_PhpScoper006a73f0e455\\Contributte\\Translation\\Wrappers\\Message']]]);
};
