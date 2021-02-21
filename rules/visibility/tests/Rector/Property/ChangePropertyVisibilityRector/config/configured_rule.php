<?php

namespace RectorPrefix20210221;

use Rector\Core\ValueObject\Visibility;
use Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector;
use Rector\Visibility\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject;
use RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210221\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector::class)->call('configure', [[\Rector\Visibility\Rector\Property\ChangePropertyVisibilityRector::PROPERTY_TO_VISIBILITY_BY_CLASS => [\Rector\Visibility\Tests\Rector\Property\ChangePropertyVisibilityRector\Source\ParentObject::class => ['toBePublicProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC, 'toBeProtectedProperty' => \Rector\Core\ValueObject\Visibility::PROTECTED, 'toBePrivateProperty' => \Rector\Core\ValueObject\Visibility::PRIVATE, 'toBePublicStaticProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC], 'Rector\\Visibility\\Tests\\Rector\\Property\\ChangePropertyVisibilityRector\\Fixture\\Fixture3' => ['toBePublicStaticProperty' => \Rector\Core\ValueObject\Visibility::PUBLIC]]]]);
};
