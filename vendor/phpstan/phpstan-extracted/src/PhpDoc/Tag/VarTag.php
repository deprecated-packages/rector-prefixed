<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc\Tag;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
class VarTag implements \_PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\TypedTag
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
     * @param Type $type
     * @return self
     */
    public function withType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\TypedTag
    {
        return new self($type);
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
