<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo;
use _PhpScoper0a2ac50786fa\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoper0a2ac50786fa\Symplify\Skipper\ValueObject\Option::ONLY, [
        \_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class => ['SomeFileToOnlyInclude.php'],
        // these 2 lines should be identical
        \_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely::class => null,
        \_PhpScoper0a2ac50786fa\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo::class,
    ]);
};
