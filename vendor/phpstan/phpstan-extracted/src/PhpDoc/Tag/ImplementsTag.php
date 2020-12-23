<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\Tag;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class ImplementsTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->type;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['type']);
    }
}
