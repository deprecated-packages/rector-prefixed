<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Ramsey\Uuid;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Ramsey\\Uuid\\Uuid')) {
    return;
}
class Uuid implements \_PhpScoperbd5d0c5f7638\Ramsey\Uuid\UuidInterface
{
    public static function uuid4() : self
    {
        return new \_PhpScoperbd5d0c5f7638\Ramsey\Uuid\Uuid();
    }
    public function toString()
    {
        // dummy value
        return '%s-%s-%s-%s-%s';
    }
}
