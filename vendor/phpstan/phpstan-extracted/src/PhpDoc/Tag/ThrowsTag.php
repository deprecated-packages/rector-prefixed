<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\PhpDoc\Tag;

use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class ThrowsTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->type;
    }
    /**
     * @param mixed[] $properties
     * @return ThrowsTag
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['type']);
    }
}
