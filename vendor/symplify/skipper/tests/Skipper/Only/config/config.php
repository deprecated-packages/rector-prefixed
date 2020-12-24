<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely;
use _PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo;
use _PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\_PhpScoperb75b35f52b74\Symplify\Skipper\ValueObject\Option::ONLY, [
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Only\Source\IncludeThisClass::class => ['SomeFileToOnlyInclude.php'],
        // these 2 lines should be identical
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletely::class => null,
        \_PhpScoperb75b35f52b74\Symplify\Skipper\Tests\Skipper\Only\Source\SkipCompletelyToo::class,
    ]);
};
