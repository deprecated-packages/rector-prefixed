<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc\Tag;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ExtendsTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Type $type)
    {
        $this->type = $type;
    }
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
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
