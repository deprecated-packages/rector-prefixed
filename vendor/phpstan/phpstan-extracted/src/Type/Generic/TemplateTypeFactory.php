<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Generic;

use _PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\TemplateTag;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
final class TemplateTypeFactory
{
    public static function create(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope $scope, string $name, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $bound, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $variance) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $strategy = new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeParameterStrategy();
        if ($bound === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        if ($bound instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateObjectType($scope, $strategy, $variance, $name, $bound->getClassName());
        }
        $boundClass = \get_class($bound);
        if ($boundClass === \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType::class) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateObjectWithoutClassType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \_PhpScopere8e811afab72\PHPStan\Type\MixedType::class) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
    }
    public static function fromTemplateTag(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeScope $scope, \_PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\TemplateTag $tag) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return self::create($scope, $tag->getName(), $tag->getBound(), $tag->getVariance());
    }
}
