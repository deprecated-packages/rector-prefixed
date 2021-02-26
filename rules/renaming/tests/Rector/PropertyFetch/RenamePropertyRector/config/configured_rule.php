<?php

namespace RectorPrefix20210226;

use Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector;
use Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties;
use Rector\Renaming\ValueObject\RenameProperty;
use RectorPrefix20210226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\RectorPrefix20210226\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::class)->call('configure', [[\Rector\Renaming\Rector\PropertyFetch\RenamePropertyRector::RENAMED_PROPERTIES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([new \Rector\Renaming\ValueObject\RenameProperty(\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'oldProperty', 'newProperty'), new \Rector\Renaming\ValueObject\RenameProperty(\Rector\Renaming\Tests\Rector\PropertyFetch\RenamePropertyRector\Source\ClassWithProperties::class, 'anotherOldProperty', 'anotherNewProperty')])]]);
};
