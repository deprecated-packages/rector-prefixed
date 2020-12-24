<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a6b37af0871\\Kdyby\\Translation\\Translator' => '_PhpScoper0a6b37af0871\\Nette\\Localization\\ITranslator', '_PhpScoper0a6b37af0871\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper0a6b37af0871\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper0a6b37af0871\\Kdyby\\Translation\\Phrase' => '_PhpScoper0a6b37af0871\\Contributte\\Translation\\Wrappers\\Message']]]);
};
