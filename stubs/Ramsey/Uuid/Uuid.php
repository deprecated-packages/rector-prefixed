<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Ramsey\Uuid;

if (\class_exists('_PhpScoperabd03f0baf05\\Ramsey\\Uuid\\Uuid')) {
    return;
}
class Uuid implements \_PhpScoperabd03f0baf05\Ramsey\Uuid\UuidInterface
{
    public static function uuid4() : self
    {
        return new \_PhpScoperabd03f0baf05\Ramsey\Uuid\Uuid();
    }
    public function toString()
    {
        // dummy value
        return '%s-%s-%s-%s-%s';
    }
}
