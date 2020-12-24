<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense;
use _PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option::SKIP, [
        // windows like path
        '*\\SomeSkipped\\*',
        // elements
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement::class,
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense::class,
    ]);
};
