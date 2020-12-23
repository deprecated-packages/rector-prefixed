<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper0a2ac50786fa\\Kdyby\\Translation\\Translator' => '_PhpScoper0a2ac50786fa\\Nette\\Localization\\ITranslator', '_PhpScoper0a2ac50786fa\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper0a2ac50786fa\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper0a2ac50786fa\\Kdyby\\Translation\\Phrase' => '_PhpScoper0a2ac50786fa\\Contributte\\Translation\\Wrappers\\Message']]]);
};
