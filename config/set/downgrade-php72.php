<?php

declare (strict_types=1);
namespace RectorPrefix20210121;

use Rector\DowngradePhp72\Rector\ClassMethod\DowngradeParameterTypeWideningRector;
use Rector\DowngradePhp72\Rector\FunctionLike\DowngradeParamObjectTypeDeclarationRector;
use Rector\DowngradePhp72\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector;
use RectorPrefix20210121\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210121\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeParamObjectTypeDeclarationRector::class);
    $services->set(\Rector\DowngradePhp72\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector::class);
    $services->set(\Rector\DowngradePhp72\Rector\ClassMethod\DowngradeParameterTypeWideningRector::class);
};
