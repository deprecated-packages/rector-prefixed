<?php

namespace RectorPrefix20210227;

use Rector\Core\ValueObject\Visibility;
use Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector;
use Rector\Visibility\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject;
use Rector\Visibility\ValueObject\ChangeMethodVisibility;
use RectorPrefix20210227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210227\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector::class)->call('configure', [[\Rector\Visibility\Rector\ClassMethod\ChangeMethodVisibilityRector::METHOD_VISIBILITIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Visibility\ValueObject\ChangeMethodVisibility(\Rector\Visibility\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicMethod', \Rector\Core\ValueObject\Visibility::PUBLIC), new \Rector\Visibility\ValueObject\ChangeMethodVisibility(\Rector\Visibility\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBeProtectedMethod', \Rector\Core\ValueObject\Visibility::PROTECTED), new \Rector\Visibility\ValueObject\ChangeMethodVisibility(\Rector\Visibility\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePrivateMethod', \Rector\Core\ValueObject\Visibility::PRIVATE), new \Rector\Visibility\ValueObject\ChangeMethodVisibility(\Rector\Visibility\Tests\Rector\ClassMethod\ChangeMethodVisibilityRector\Source\ParentObject::class, 'toBePublicStaticMethod', \Rector\Core\ValueObject\Visibility::PUBLIC)])]]);
};
