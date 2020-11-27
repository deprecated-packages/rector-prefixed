<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Ramsey\Uuid;

if (\class_exists('_PhpScoper88fe6e0ad041\\Ramsey\\Uuid\\Uuid')) {
    return;
}
class Uuid implements \_PhpScoper88fe6e0ad041\Ramsey\Uuid\UuidInterface
{
    public static function uuid4() : self
    {
        return new \_PhpScoper88fe6e0ad041\Ramsey\Uuid\Uuid();
    }
    public function toString()
    {
        // dummy value
        return '%s-%s-%s-%s-%s';
    }
}
