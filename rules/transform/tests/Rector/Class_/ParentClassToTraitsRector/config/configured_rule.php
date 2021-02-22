<?php

namespace RectorPrefix20210222;

use Rector\Transform\Rector\Class_\ParentClassToTraitsRector;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait;
use Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait;
use Rector\Transform\ValueObject\ParentClassToTraits;
use RectorPrefix20210222\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210222\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Transform\Rector\Class_\ParentClassToTraitsRector::class)->call('configure', [[\Rector\Transform\Rector\Class_\ParentClassToTraitsRector::PARENT_CLASS_TO_TRAITS => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Transform\ValueObject\ParentClassToTraits(\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\ParentObject::class, [\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class]), new \Rector\Transform\ValueObject\ParentClassToTraits(\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\AnotherParentObject::class, [\Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SomeTrait::class, \Rector\Transform\Tests\Rector\Class_\ParentClassToTraitsRector\Source\SecondTrait::class])])]]);
};
