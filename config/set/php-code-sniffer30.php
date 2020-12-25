<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHP_CodeSniffer_Sniffs_Sniff' => '_PhpScoperbf340cb0be9d\\PHP_CodeSniffer\\Sniffs\\Sniff', 'PHP_CodeSniffer_File' => '_PhpScoperbf340cb0be9d\\PHP_CodeSniffer\\Files\\File', 'PHP_CodeSniffer_Tokens' => '_PhpScoperbf340cb0be9d\\PHP_CodeSniffer\\Util\\Tokens']]]);
};
