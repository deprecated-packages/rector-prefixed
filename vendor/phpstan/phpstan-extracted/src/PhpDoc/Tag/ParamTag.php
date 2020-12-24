<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc\Tag;

use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ParamTag implements \_PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\TypedTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $isVariadic;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, bool $isVariadic)
    {
        $this->type = $type;
        $this->isVariadic = $isVariadic;
    }
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function isVariadic() : bool
    {
        return $this->isVariadic;
    }
    /**
     * @param Type $type
     * @return self
     */
    public function withType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : \_PhpScopere8e811afab72\PHPStan\PhpDoc\Tag\TypedTag
    {
        return new self($type, $this->isVariadic);
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['type'], $properties['isVariadic']);
    }
}
