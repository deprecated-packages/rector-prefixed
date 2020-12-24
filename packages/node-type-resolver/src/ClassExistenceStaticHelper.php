<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver;

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
