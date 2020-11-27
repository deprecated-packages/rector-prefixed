<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

use Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector;
use Rector\Generic\ValueObject\RemoveFuncCallArg;
use Rector\Php52\Rector\Property\VarToPublicPropertyRector;
use Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Php52\Rector\Property\VarToPublicPropertyRector::class);
    $services->set(\Rector\Php52\Rector\Switch_\ContinueToBreakInSwitchRector::class);
    $services->set(\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::class)->call('configure', [[\Rector\Generic\Rector\FuncCall\RemoveFuncCallArgRector::REMOVED_FUNCTION_ARGUMENTS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // see https://www.php.net/manual/en/function.ldap-first-attribute.php
        new \Rector\Generic\ValueObject\RemoveFuncCallArg('ldap_first_attribute', 2),
    ])]]);
};
