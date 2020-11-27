<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScopera143bcca66cb\\Kdyby\\Translation\\Translator' => '_PhpScopera143bcca66cb\\Nette\\Localization\\ITranslator', '_PhpScopera143bcca66cb\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScopera143bcca66cb\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScopera143bcca66cb\\Kdyby\\Translation\\Phrase' => '_PhpScopera143bcca66cb\\Contributte\\Translation\\Wrappers\\Message']]]);
};
