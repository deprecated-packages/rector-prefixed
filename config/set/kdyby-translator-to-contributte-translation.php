<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['_PhpScoperb75b35f52b74\\Kdyby\\Translation\\Translator' => '_PhpScoperb75b35f52b74\\Nette\\Localization\\ITranslator', '_PhpScoperb75b35f52b74\\Kdyby\\Translation\\DI\\ITranslationProvider' => '_PhpScoperb75b35f52b74\\Contributte\\Translation\\DI\\TranslationProviderInterface', '_PhpScoperb75b35f52b74\\Kdyby\\Translation\\Phrase' => '_PhpScoperb75b35f52b74\\Contributte\\Translation\\Wrappers\\Message']]]);
};
