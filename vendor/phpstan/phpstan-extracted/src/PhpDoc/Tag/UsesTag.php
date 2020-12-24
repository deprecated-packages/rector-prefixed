<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class UsesTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
