<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\Type\ErrorType;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;
class TemplateTypeHelper
{
    /**
     * Replaces template types with standin types
     */
    public static function resolveTemplateTypes(\PHPStan\Type\Type $type, \PHPStan\Type\Generic\TemplateTypeMap $standins) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeTraverser::map($type, static function (\PHPStan\Type\Type $type, callable $traverse) use($standins) : Type {
            if ($type instanceof \PHPStan\Type\Generic\TemplateType && !$type->isArgument()) {
                $newType = $standins->getType($type->getName()) ?? $type;
                if ($newType instanceof \PHPStan\Type\ErrorType) {
                    $newType = $type->getBound();
                }
                if ($newType instanceof \PHPStan\Type\StaticType) {
                    $newType = $newType->getStaticObjectType();
                }
                return $newType;
            }
            return $traverse($type);
        });
    }
    public static function resolveToBounds(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeTraverser::map($type, static function (\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->getBound());
            }
            return $traverse($type);
        });
    }
    /**
     * Switches all template types to their argument strategy
     */
    public static function toArgument(\PHPStan\Type\Type $type) : \PHPStan\Type\Type
    {
        return \PHPStan\Type\TypeTraverser::map($type, static function (\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->toArgument());
            }
            return $traverse($type);
        });
    }
}
