<?php

declare (strict_types=1);
namespace Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\config;

use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\ServiceWithValueObject;
use Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210322\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $withType = new \Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType(new \PHPStan\Type\IntegerType());
    $services->set(\Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\ServiceWithValueObject::class)->call('setWithType', [\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline($withType)])->call('setWithTypes', [\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType(new \PHPStan\Type\StringType())])]);
};
