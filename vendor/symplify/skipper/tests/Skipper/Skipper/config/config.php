<?php

declare (strict_types=1);
namespace RectorPrefix20210211;

use RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use RectorPrefix20210211\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement;
use RectorPrefix20210211\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense;
use RectorPrefix20210211\Symplify\Skipper\ValueObject\Option;
return static function (\RectorPrefix20210211\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\RectorPrefix20210211\Symplify\Skipper\ValueObject\Option::SKIP, [
        // windows like path
        '*\\SomeSkipped\\*',
        // elements
        \RectorPrefix20210211\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement::class,
        \RectorPrefix20210211\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense::class,
    ]);
};
