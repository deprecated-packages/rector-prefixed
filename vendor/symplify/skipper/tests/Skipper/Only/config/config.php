<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely;
use _PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo;
use _PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScopere8e811afab72\Symplify\Skipper\ValueObject\Option::ONLY, [
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class => ['SomeFileToOnlyInclude.php'],
        // these 2 lines should be identical
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely::class => null,
        \_PhpScopere8e811afab72\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo::class,
    ]);
};
