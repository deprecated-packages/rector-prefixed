<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper267b3276efc2\\Kdyby\\Translation\\Translator' => '_PhpScoper267b3276efc2\\Nette\\Localization\\ITranslator', '_PhpScoper267b3276efc2\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper267b3276efc2\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper267b3276efc2\\Kdyby\\Translation\\Phrase' => '_PhpScoper267b3276efc2\\Contributte\\Translation\\Wrappers\\Message']]]);
};
