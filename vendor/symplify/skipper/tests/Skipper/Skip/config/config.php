<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip;
use _PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option::SKIP, [
        // classes
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Skip\Source\SomeClassToSkip::class,
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class => ['Fixture/someFile', '*/someDirectory/*'],
        // code
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someCode' => null,
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someOtherCode' => ['*/someDirectory/*'],
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Skip\Source\AnotherClassToSkip::class . '.someAnotherCode' => ['someDirectory/*'],
        // file paths
        __DIR__ . '/../Fixture/AlwaysSkippedPath',
        '*\\PathSkippedWithMask\\*',
        // messages
        'some fishy code at line 5!' => null,
        'some another fishy code at line 5!' => ['someDirectory/*'],
        'Cognitive complexity for method "foo" is 2 but has to be less than or equal to 1.' => null,
    ]);
};
