<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use _PhpScoperb75b35f52b74\Rector\Generic\ValueObject\RemoveFuncCallArg;
use _PhpScoperb75b35f52b74\Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use _PhpScoperb75b35f52b74\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php52\Rector\Property\VarToPublicPropertyRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector::class);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // see https://www.php.net/manual/en/function.ldap-first-attribute.php
        new \_PhpScoperb75b35f52b74\Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2),
    ])]]);
};
