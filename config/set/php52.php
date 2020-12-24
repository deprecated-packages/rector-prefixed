<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use _PhpScopere8e811afab72\Rector\Generic\ValueObject\RemoveFuncCallArg;
use _PhpScopere8e811afab72\Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use _PhpScopere8e811afab72\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Php52\Rector\Property\VarToPublicPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // see https://www.php.net/manual/en/function.ldap-first-attribute.php
        new \_PhpScopere8e811afab72\Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2),
    ])]]);
};
