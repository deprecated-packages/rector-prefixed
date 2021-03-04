<?php

declare (strict_types=1);
namespace RectorPrefix20210304;

use Rector\Privatization\Rector\MethodCall\ReplaceStringWithClassConstantRector;
use Rector\Privatization\Tests\Rector\MethodCall\ReplaceStringWithClassConstantRector\Source\Placeholder;
use Rector\Privatization\ValueObject\ReplaceStringWithClassConstant;
use RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210304\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Privatization\Rector\MethodCall\ReplaceStringWithClassConstantRector::class)->call('configure', [[\Rector\Privatization\Rector\MethodCall\ReplaceStringWithClassConstantRector::REPLACE_STRING_WITH_CLASS_CONSTANT => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Privatization\ValueObject\ReplaceStringWithClassConstant('Rector\\Privatization\\Tests\\Rector\\MethodCall\\ReplaceStringWithClassConstantRector\\Fixture\\ReplaceWithConstant', 'call', 0, \Rector\Privatization\Tests\Rector\MethodCall\ReplaceStringWithClassConstantRector\Source\Placeholder::class)])]]);
};
