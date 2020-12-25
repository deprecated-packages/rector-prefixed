<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper567b66d83109\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper567b66d83109\\Kdyby\\Translation\\Translator' => '_PhpScoper567b66d83109\\Nette\\Localization\\ITranslator', '_PhpScoper567b66d83109\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper567b66d83109\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper567b66d83109\\Kdyby\\Translation\\Phrase' => '_PhpScoper567b66d83109\\Contributte\\Translation\\Wrappers\\Message']]]);
};
