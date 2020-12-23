<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\Tag;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class ReturnTag implements \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\Tag\TypedTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $isExplicit;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, bool $isExplicit)
    {
        $this->type = $type;
        $this->isExplicit = $isExplicit;
    }
    public function getType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function isExplicit() : bool
    {
        return $this->isExplicit;
    }
    /**
     * @param Type $type
     * @return self
     */
    public function withType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\Tag\TypedTag
    {
        return new self($type, $this->isExplicit);
    }
    public function toImplicit() : self
    {
        return new self($this->type, \false);
    }
    /**
     * @param mixed[] $properties
     * @return ReturnTag
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['type'], $properties['isExplicit']);
    }
}
