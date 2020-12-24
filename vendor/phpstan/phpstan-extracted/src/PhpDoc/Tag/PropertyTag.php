<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class PropertyTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $readable;
    /** @var bool */
    private $writable;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $readable, bool $writable)
    {
        $this->type = $type;
        $this->readable = $readable;
        $this->writable = $writable;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function isReadable() : bool
    {
        return $this->readable;
    }
    public function isWritable() : bool
    {
        return $this->writable;
    }
    /**
     * @param mixed[] $properties
     * @return PropertyTag
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['type'], $properties['readable'], $properties['writable']);
    }
}
