<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\RemoveFuncCallArg;
use _PhpScoper2a4e7ab1ecbc\Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php52\Rector\Property\VarToPublicPropertyRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector::class);
    $services->set(\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class)->call('configure', [[\_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => \_PhpScoper2a4e7ab1ecbc\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // see https://www.php.net/manual/en/function.ldap-first-attribute.php
        new \_PhpScoper2a4e7ab1ecbc\Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2),
    ])]]);
};
