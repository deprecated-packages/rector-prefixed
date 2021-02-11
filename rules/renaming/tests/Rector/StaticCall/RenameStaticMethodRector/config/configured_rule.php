<?php

namespace RectorPrefix20210211;

use RectorPrefix20210211\Nette\Utils\Html;
use Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros;
use Rector\Renaming\ValueObject\RenameStaticMethod;
use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameStaticMethod(\RectorPrefix20210211\Nette\Utils\Html::class, 'add', \RectorPrefix20210211\Nette\Utils\Html::class, 'addHtml'), new \Rector\Renaming\ValueObject\RenameStaticMethod(\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros::class, 'renderFormBegin', 'Nette\\Bridges\\FormsLatte\\Runtime', 'renderFormBegin')])]]);
};
