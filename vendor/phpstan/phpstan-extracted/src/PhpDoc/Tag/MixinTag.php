<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class MixinTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
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
