<?php

declare (strict_types=1);
namespace RectorPrefix20210126;

use Rector\Renaming\Rector\Name\RenameClassRector;
use RectorPrefix20210126\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210126\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHP_CodeSniffer_Sniffs_Sniff' => 'PHP_CodeSniffer\\Sniffs\\Sniff', 'PHP_CodeSniffer_File' => 'PHP_CodeSniffer\\Files\\File', 'PHP_CodeSniffer_Tokens' => 'PHP_CodeSniffer\\Util\\Tokens']]]);
};
