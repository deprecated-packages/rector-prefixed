<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix2020DecSat\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHP_CodeSniffer_Sniffs_Sniff' => 'RectorPrefix2020DecSat\\PHP_CodeSniffer\\Sniffs\\Sniff', 'PHP_CodeSniffer_File' => 'RectorPrefix2020DecSat\\PHP_CodeSniffer\\Files\\File', 'PHP_CodeSniffer_Tokens' => 'RectorPrefix2020DecSat\\PHP_CodeSniffer\\Util\\Tokens']]]);
};
