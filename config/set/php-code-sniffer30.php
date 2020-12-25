<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHP_CodeSniffer_Sniffs_Sniff' => '_PhpScoper8b9c402c5f32\\PHP_CodeSniffer\\Sniffs\\Sniff', 'PHP_CodeSniffer_File' => '_PhpScoper8b9c402c5f32\\PHP_CodeSniffer\\Files\\File', 'PHP_CodeSniffer_Tokens' => '_PhpScoper8b9c402c5f32\\PHP_CodeSniffer\\Util\\Tokens']]]);
};
