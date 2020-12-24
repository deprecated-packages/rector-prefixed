<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip;
use _PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option::SKIP, [
        // classes
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip::class,
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class => ['Fixture/someFile', '*/someDirectory/*'],
        // code
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someCode' => null,
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someOtherCode' => ['*/someDirectory/*'],
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someAnotherCode' => ['someDirectory/*'],
        // file paths
        __DIR__ . '/../Fixture/AlwaysSkippedPath',
        '*\\PathSkippedWithMask\\*',
        // messages
        'some fishy code at line 5!' => null,
        'some another fishy code at line 5!' => ['someDirectory/*'],
        'Cognitive complexity for method "foo" is 2 but has to be less than or equal to 1.' => null,
    ]);
};
