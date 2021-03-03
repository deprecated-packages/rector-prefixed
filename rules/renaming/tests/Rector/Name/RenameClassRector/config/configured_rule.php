<?php

namespace RectorPrefix20210303;

use RectorPrefix20210303\Acme\Bar\DoNotUpdateExistingTargetNamespace;
use RectorPrefix20210303\Manual\Twig\TwigFilter;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\Contract\FirstInterface;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\Contract\SecondInterface;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\Contract\ThirdInterface;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\SomeFinalClass;
use Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\SomeNonFinalClass;
use RectorPrefix20210303\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210303\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        'FqnizeNamespaced' => 'Abc\\FqnizeNamespaced',
        \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
        \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo::class => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo::class,
        'DateTime' => 'DateTimeInterface',
        'Countable' => 'stdClass',
        \RectorPrefix20210303\Manual_Twig_Filter::class => \RectorPrefix20210303\Manual\Twig\TwigFilter::class,
        'Twig_AbstractManualExtension' => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension::class,
        'Twig_Extension_Sandbox' => 'Twig\\Extension\\SandboxExtension',
        // Renaming class itself and its namespace
        'MyNamespace\\MyClass' => 'MyNewNamespace\\MyNewClass',
        'MyNamespace\\MyTrait' => 'MyNewNamespace\\MyNewTrait',
        'MyNamespace\\MyInterface' => 'MyNewNamespace\\MyNewInterface',
        'MyOldClass' => 'MyNamespace\\MyNewClass',
        'AnotherMyOldClass' => 'AnotherMyNewClass',
        'MyNamespace\\AnotherMyClass' => 'MyNewClassWithoutNamespace',
        // test duplicated class - @see https://github.com/rectorphp/rector/issues/1438
        'Rector\\Renaming\\Tests\\Rector\\Name\\RenameClassRector\\Fixture\\SingularClass' => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass::class,
        // test duplicated class - @see https://github.com/rectorphp/rector/issues/5389
        \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\Contract\FirstInterface::class => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\Contract\ThirdInterface::class,
        \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\Contract\SecondInterface::class => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\Contract\ThirdInterface::class,
        \RectorPrefix20210303\Acme\Foo\DoNotUpdateExistingTargetNamespace::class => \RectorPrefix20210303\Acme\Bar\DoNotUpdateExistingTargetNamespace::class,
        \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\SomeNonFinalClass::class => \Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\SomeFinalClass::class,
    ]]]);
};
