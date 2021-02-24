<?php

namespace RectorPrefix20210224;

use Rector\Core\ValueObject\Visibility;
use Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector;
use Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject;
use Rector\Visibility\ValueObject\ChangeConstantVisibility;
use RectorPrefix20210224\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210224\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector::class)->call('configure', [[\Rector\Visibility\Rector\ClassConst\ChangeConstantVisibilityRector::CLASS_CONSTANT_VISIBILITY_CHANGES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Visibility\ValueObject\ChangeConstantVisibility(\Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PUBLIC_CONSTANT', \Rector\Core\ValueObject\Visibility::PUBLIC), new \Rector\Visibility\ValueObject\ChangeConstantVisibility(\Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PROTECTED_CONSTANT', \Rector\Core\ValueObject\Visibility::PROTECTED), new \Rector\Visibility\ValueObject\ChangeConstantVisibility(\Rector\Visibility\Tests\Rector\ClassConst\ChangeConstantVisibilityRector\Source\ParentObject::class, 'TO_BE_PRIVATE_CONSTANT', \Rector\Core\ValueObject\Visibility::PRIVATE), new \Rector\Visibility\ValueObject\ChangeConstantVisibility('Rector\\Visibility\\Tests\\Rector\\ClassConst\\ChangeConstantVisibilityRector\\Fixture\\Fixture2', 'TO_BE_PRIVATE_CONSTANT', \Rector\Core\ValueObject\Visibility::PRIVATE)])]]);
};
