<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass;
use Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely;
use Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo;
use Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Symplify\Skipper\ValueObject\Option::ONLY, [
        \Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class => ['SomeFileToOnlyInclude.php'],
        // these 2 lines should be identical
        \Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely::class => null,
        \Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo::class,
    ]);
};
