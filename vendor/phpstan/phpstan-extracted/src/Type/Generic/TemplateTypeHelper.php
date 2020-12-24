<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser;
class TemplateTypeHelper
{
    /**
     * Replaces template types with standin types
     */
    public static function resolveTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap $standins) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $traverse) use($standins) : Type {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType && !$type->isArgument()) {
                $newType = $standins->getType($type->getName()) ?? $type;
                if ($newType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
                    $newType = $type->getBound();
                }
                if ($newType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType) {
                    $newType = $newType->getStaticObjectType();
                }
                return $newType;
            }
            return $traverse($type);
        });
    }
    public static function resolveToBounds(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->getBound());
            }
            return $traverse($type);
        });
    }
    /**
     * Switches all template types to their argument strategy
     */
    public static function toArgument(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->toArgument());
            }
            return $traverse($type);
        });
    }
}
