<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver;

final class ClassExistenceStaticHelper
{
    public static function doesClassLikeExist(string $classLike) : bool
    {
        if (\class_exists($classLike)) {
            return \true;
        }
        if (\interface_exists($classLike)) {
            return \true;
        }
        return \trait_exists($classLike);
    }
}
