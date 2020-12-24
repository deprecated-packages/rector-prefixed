<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\TemplateTag;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
final class TemplateTypeFactory
{
    public static function create(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope $scope, string $name, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $bound, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $variance) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $strategy = new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeParameterStrategy();
        if ($bound === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        if ($bound instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateObjectType($scope, $strategy, $variance, $name, $bound->getClassName());
        }
        $boundClass = \get_class($bound);
        if ($boundClass === \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType::class) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateObjectWithoutClassType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType::class) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
    }
    public static function fromTemplateTag(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeScope $scope, \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\TemplateTag $tag) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return self::create($scope, $tag->getName(), $tag->getBound(), $tag->getVariance());
    }
}
