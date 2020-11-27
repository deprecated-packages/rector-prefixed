<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Ramsey\Uuid;

if (\class_exists('_PhpScoper26e51eeacccf\\Ramsey\\Uuid\\Uuid')) {
    return;
}
class Uuid implements \_PhpScoper26e51eeacccf\Ramsey\Uuid\UuidInterface
{
    public static function uuid4() : self
    {
        return new \_PhpScoper26e51eeacccf\Ramsey\Uuid\Uuid();
    }
    public function toString()
    {
        // dummy value
        return '%s-%s-%s-%s-%s';
    }
}
