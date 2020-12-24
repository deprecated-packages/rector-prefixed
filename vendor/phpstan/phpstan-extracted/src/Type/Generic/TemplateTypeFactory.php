<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Generic;

use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\Tag\TemplateTag;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
final class TemplateTypeFactory
{
    public static function create(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeScope $scope, string $name, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $bound, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance $variance) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $strategy = new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeParameterStrategy();
        if ($bound === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        if ($bound instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateObjectType($scope, $strategy, $variance, $name, $bound->getClassName());
        }
        $boundClass = \get_class($bound);
        if ($boundClass === \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType::class) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateObjectWithoutClassType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType::class) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
    }
    public static function fromTemplateTag(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeScope $scope, \_PhpScoper0a6b37af0871\PHPStan\PhpDoc\Tag\TemplateTag $tag) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return self::create($scope, $tag->getName(), $tag->getBound(), $tag->getVariance());
    }
}
