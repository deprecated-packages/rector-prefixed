<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip;
use Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip;
use Symplify\Skipper\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SKIP, [
        // classes
        SomeClassToSkip::class,

        AnotherClassToSkip::class => ['Fixture/someFile', '*/someDirectory/*'],

        // code
        AnotherClassToSkip::class . '.someCode' => null,
        AnotherClassToSkip::class . '.someOtherCode' => ['*/someDirectory/*'],
        AnotherClassToSkip::class . '.someAnotherCode' => ['someDirectory/*'],

        // file paths
        __DIR__ . '/../Fixture/AlwaysSkippedPath',
        '*\PathSkippedWithMask\*',

        // messages
        'some fishy code at line 5!' => null,
        'some another fishy code at line 5!' => ['someDirectory/*'],
        'Cognitive complexity for method "foo" is 2 but has to be less than or equal to 1.' => null,
    ]);
};
