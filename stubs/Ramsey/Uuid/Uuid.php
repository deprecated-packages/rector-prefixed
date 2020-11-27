<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Ramsey\Uuid;

if (\class_exists('_PhpScopera143bcca66cb\\Ramsey\\Uuid\\Uuid')) {
    return;
}
class Uuid implements \_PhpScopera143bcca66cb\Ramsey\Uuid\UuidInterface
{
    public static function uuid4() : self
    {
        return new \_PhpScopera143bcca66cb\Ramsey\Uuid\Uuid();
    }
    public function toString()
    {
        // dummy value
        return '%s-%s-%s-%s-%s';
    }
}
