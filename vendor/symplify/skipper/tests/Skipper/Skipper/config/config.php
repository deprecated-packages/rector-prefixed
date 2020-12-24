<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871;

use _PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement;
use _PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense;
use _PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoper0a6b37af0871\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a6b37af0871\Symplify\Skipper\ValueObject\Option::SKIP, [
        // windows like path
        '*\\SomeSkipped\\*',
        // elements
        \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement::class,
        \_PhpScoper0a6b37af0871\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense::class,
    ]);
};
