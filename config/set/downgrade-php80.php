<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Catch_\DowngradeNonCapturingCatchesRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Class_\DowngradePropertyPromotionToConstructorPropertyAssignRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\ClassConstFetch\DowngradeClassOnObjectToGetClassRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\ClassMethod\DowngradeTrailingCommasInParamUseRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Expression\DowngradeMatchToSwitchRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnStaticTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeParamDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\NullsafeMethodCall\DowngradeNullsafeToTernaryOperatorRector;
use _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Property\DowngradeUnionTypeTypedPropertyRector;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Property\DowngradeUnionTypeTypedPropertyRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeReturnDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeUnionTypeParamDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeParamMixedTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnMixedTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\FunctionLike\DowngradeReturnStaticTypeDeclarationRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Class_\DowngradePropertyPromotionToConstructorPropertyAssignRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Catch_\DowngradeNonCapturingCatchesRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\Expression\DowngradeMatchToSwitchRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\ClassConstFetch\DowngradeClassOnObjectToGetClassRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\NullsafeMethodCall\DowngradeNullsafeToTernaryOperatorRector::class);
    $services->set(\_PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\ClassMethod\DowngradeTrailingCommasInParamUseRector::class);
};
