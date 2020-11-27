<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

use Rector\Renaming\Rector\Name\RenameClassRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoper26e51eeacccf\\Kdyby\\Translation\\Translator' => '_PhpScoper26e51eeacccf\\Nette\\Localization\\ITranslator', '_PhpScoper26e51eeacccf\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoper26e51eeacccf\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoper26e51eeacccf\\Kdyby\\Translation\\Phrase' => '_PhpScoper26e51eeacccf\\Contributte\\Translation\\Wrappers\\Message']]]);
};
