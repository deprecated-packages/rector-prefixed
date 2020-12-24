<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\TemplateTag;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
final class TemplateTypeFactory
{
    public static function create(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeScope $scope, string $name, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $bound, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $variance) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $strategy = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeParameterStrategy();
        if ($bound === null) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        if ($bound instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateObjectType($scope, $strategy, $variance, $name, $bound->getClassName());
        }
        $boundClass = \get_class($bound);
        if ($boundClass === \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType::class) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateObjectWithoutClassType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType::class) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
    }
    public static function fromTemplateTag(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeScope $scope, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag\TemplateTag $tag) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return self::create($scope, $tag->getName(), $tag->getBound(), $tag->getVariance());
    }
}
