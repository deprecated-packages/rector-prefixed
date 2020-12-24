<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip;
use _PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option::SKIP, [
        // classes
        \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip::class,
        \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class => ['Fixture/someFile', '*/someDirectory/*'],
        // code
        \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someCode' => null,
        \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someOtherCode' => ['*/someDirectory/*'],
        \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someAnotherCode' => ['someDirectory/*'],
        // file paths
        __DIR__ . '/../Fixture/AlwaysSkippedPath',
        '*\\PathSkippedWithMask\\*',
        // messages
        'some fishy code at line 5!' => null,
        'some another fishy code at line 5!' => ['someDirectory/*'],
        'Cognitive complexity for method "foo" is 2 but has to be less than or equal to 1.' => null,
    ]);
};
