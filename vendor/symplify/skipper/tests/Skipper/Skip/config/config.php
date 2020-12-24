<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\ValueObject\Option::SKIP, [
        // classes
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip::class,
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class => ['Fixture/someFile', '*/someDirectory/*'],
        // code
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someCode' => null,
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someOtherCode' => ['*/someDirectory/*'],
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someAnotherCode' => ['someDirectory/*'],
        // file paths
        __DIR__ . '/../Fixture/AlwaysSkippedPath',
        '*\\PathSkippedWithMask\\*',
        // messages
        'some fishy code at line 5!' => null,
        'some another fishy code at line 5!' => ['someDirectory/*'],
        'Cognitive complexity for method "foo" is 2 but has to be less than or equal to 1.' => null,
    ]);
};
