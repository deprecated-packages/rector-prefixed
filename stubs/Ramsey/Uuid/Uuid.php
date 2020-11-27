<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Ramsey\Uuid;

if (\class_exists('_PhpScoper006a73f0e455\\Ramsey\\Uuid\\Uuid')) {
    return;
}
class Uuid implements \_PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface
{
    public static function uuid4() : self
    {
        return new \_PhpScoper006a73f0e455\Ramsey\Uuid\Uuid();
    }
    public function toString()
    {
        // dummy value
        return '%s-%s-%s-%s-%s';
    }
}
