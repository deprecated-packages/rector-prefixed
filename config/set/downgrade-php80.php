<?php

declare (strict_types=1);
namespace RectorPrefix20210301;

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DowngradePhp80\Rector\Catch_\DowngradeNonCapturingCatchesRector;
use Rector\DowngradePhp80\Rector\Class_\DowngradePropertyPromotionRector;
use Rector\DowngradePhp80\Rector\ClassConstFetch\DowngradeClassOnObjectToGetClassRector;
use Rector\DowngradePhp80\Rector\ClassMethod\DowngradeTrailingCommasInParamUseRector;
use Rector\DowngradePhp80\Rector\Expression\DowngradeMatchToSwitchRector;
use Rector\DowngradePhp80\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector;
use Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector;
use Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnStaticTypeDeclarationRector;
use Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeParamDeclarationRector;
use Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector;
use Rector\DowngradePhp80\Rector\NullsafeMethodCall\DowngradeNullsafeToTernaryOperatorRector;
use Rector\DowngradePhp80\Rector\Property\DowngradeUnionTypeTypedPropertyRector;
use RectorPrefix20210301\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\RectorPrefix20210301\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\DowngradePhp80\Rector\Property\DowngradeUnionTypeTypedPropertyRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeParamDeclarationRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnStaticTypeDeclarationRector::class);
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Rector\Core\Configuration\Option::PHP_VERSION_FEATURES, \Rector\Core\ValueObject\PhpVersion::PHP_74);
    // skip root namespace classes, like \DateTime or \Exception [default: true]
    $parameters->set(\Rector\Core\Configuration\Option::IMPORT_SHORT_CLASSES, \false);
    // skip classes used in PHP DocBlocks, like in /** @var \Some\Class */ [default: true]
    $parameters->set(\Rector\Core\Configuration\Option::IMPORT_DOC_BLOCKS, \false);
    $services->set(\Rector\DowngradePhp80\Rector\Class_\DowngradePropertyPromotionRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\Catch_\DowngradeNonCapturingCatchesRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\Expression\DowngradeMatchToSwitchRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\ClassConstFetch\DowngradeClassOnObjectToGetClassRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\NullsafeMethodCall\DowngradeNullsafeToTernaryOperatorRector::class);
    $services->set(\Rector\DowngradePhp80\Rector\ClassMethod\DowngradeTrailingCommasInParamUseRector::class);
};
