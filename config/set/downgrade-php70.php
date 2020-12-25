<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32;

use Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeParamDeclarationRector;
use Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeReturnDeclarationRector;
use _PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper8b9c402c5f32\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeParamDeclarationRector::class);
    $services->set(\Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeReturnDeclarationRector::class);
};
