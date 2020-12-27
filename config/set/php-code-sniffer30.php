<?php

declare (strict_types=1);
namespace RectorPrefix20201227;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20201227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHP_CodeSniffer_Sniffs_Sniff' => 'RectorPrefix20201227\\PHP_CodeSniffer\\Sniffs\\Sniff', 'PHP_CodeSniffer_File' => 'RectorPrefix20201227\\PHP_CodeSniffer\\Files\\File', 'PHP_CodeSniffer_Tokens' => 'RectorPrefix20201227\\PHP_CodeSniffer\\Util\\Tokens']]]);
};
