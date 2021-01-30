<?php

declare (strict_types=1);
namespace Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\config;

use PHPStan\Type\NullType;
use PHPStan\Type\StringType;
use PHPStan\Type\UnionType;
use RectorPrefix20210130\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\ServiceWithValueObject;
use Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210130\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $unionType = new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]);
    $services->set(\Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\ServiceWithValueObject::class)->call('setWithType', [\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline(new \Symplify\SymfonyPhpConfig\Tests\ValueObjectInliner\Source\WithType($unionType))]);
};
