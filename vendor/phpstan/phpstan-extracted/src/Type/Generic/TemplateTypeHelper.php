<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser;
class TemplateTypeHelper
{
    /**
     * Replaces template types with standin types
     */
    public static function resolveTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap $standins) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) use($standins) : Type {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType && !$type->isArgument()) {
                $newType = $standins->getType($type->getName()) ?? $type;
                if ($newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                    $newType = $type->getBound();
                }
                if ($newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
                    $newType = $newType->getStaticObjectType();
                }
                return $newType;
            }
            return $traverse($type);
        });
    }
    public static function resolveToBounds(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->getBound());
            }
            return $traverse($type);
        });
    }
    /**
     * Switches all template types to their argument strategy
     */
    public static function toArgument(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($type, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->toArgument());
            }
            return $traverse($type);
        });
    }
}
