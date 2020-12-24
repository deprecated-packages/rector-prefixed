<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo;
use _PhpScoper2a4e7ab1ecbc\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoper2a4e7ab1ecbc\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\ValueObject\Option::ONLY, [
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class => ['SomeFileToOnlyInclude.php'],
        // these 2 lines should be identical
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely::class => null,
        \_PhpScoper2a4e7ab1ecbc\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo::class,
    ]);
};
