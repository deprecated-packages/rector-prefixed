<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\PhpDoc\Tag\TemplateTag;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
final class TemplateTypeFactory
{
    public static function create(\PHPStan\Type\Generic\TemplateTypeScope $scope, string $name, ?\PHPStan\Type\Type $bound, \PHPStan\Type\Generic\TemplateTypeVariance $variance) : \PHPStan\Type\Type
    {
        $strategy = new \PHPStan\Type\Generic\TemplateTypeParameterStrategy();
        if ($bound === null) {
            return new \PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        if ($bound instanceof \PHPStan\Type\ObjectType) {
            return new \PHPStan\Type\Generic\TemplateObjectType($scope, $strategy, $variance, $name, $bound->getClassName());
        }
        $boundClass = \get_class($bound);
        if ($boundClass === \PHPStan\Type\ObjectWithoutClassType::class) {
            return new \PHPStan\Type\Generic\TemplateObjectWithoutClassType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \PHPStan\Type\MixedType::class) {
            return new \PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        return new \PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
    }
    public static function fromTemplateTag(\PHPStan\Type\Generic\TemplateTypeScope $scope, \PHPStan\PhpDoc\Tag\TemplateTag $tag) : \PHPStan\Type\Type
    {
        return self::create($scope, $tag->getName(), $tag->getBound(), $tag->getVariance());
    }
}
