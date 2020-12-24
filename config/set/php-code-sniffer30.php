<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => ['PHP_CodeSniffer_Sniffs_Sniff' => '_PhpScopere8e811afab72\\PHP_CodeSniffer\\Sniffs\\Sniff', 'PHP_CodeSniffer_File' => '_PhpScopere8e811afab72\\PHP_CodeSniffer\\Files\\File', 'PHP_CodeSniffer_Tokens' => '_PhpScopere8e811afab72\\PHP_CodeSniffer\\Util\\Tokens']]]);
};
