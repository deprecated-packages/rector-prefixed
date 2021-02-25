<?php

declare (strict_types=1);
namespace RectorPrefix20210225;

use Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeParamDeclarationRector;
use Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeReturnDeclarationRector;
use RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210225\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeParamDeclarationRector::class);
    $services->set(\Rector\DowngradePhp70\Rector\FunctionLike\DowngradeTypeReturnDeclarationRector::class);
};
