<?php

declare (strict_types=1);
namespace RectorPrefix20201228;

use RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20201228\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip;
use RectorPrefix20201228\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip;
use RectorPrefix20201228\Symplify\Skipper\ValueObject\Option;
return static function (\RectorPrefix20201228\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\RectorPrefix20201228\Symplify\Skipper\ValueObject\Option::SKIP, [
        // classes
        \RectorPrefix20201228\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip::class,
        \RectorPrefix20201228\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class => ['Fixture/someFile', '*/someDirectory/*'],
        // code
        \RectorPrefix20201228\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someCode' => null,
        \RectorPrefix20201228\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someOtherCode' => ['*/someDirectory/*'],
        \RectorPrefix20201228\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someAnotherCode' => ['someDirectory/*'],
        // file paths
        __DIR__ . '/../Fixture/AlwaysSkippedPath',
        '*\\PathSkippedWithMask\\*',
        // messages
        'some fishy code at line 5!' => null,
        'some another fishy code at line 5!' => ['someDirectory/*'],
        'Cognitive complexity for method "foo" is 2 but has to be less than or equal to 1.' => null,
    ]);
};
