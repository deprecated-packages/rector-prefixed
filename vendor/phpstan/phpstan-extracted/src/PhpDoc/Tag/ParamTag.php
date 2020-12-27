<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc\Tag;

use PHPStan\Type\Type;
class ParamTag implements \PHPStan\PhpDoc\Tag\TypedTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $isVariadic;
    public function __construct(\PHPStan\Type\Type $type, bool $isVariadic)
    {
        $this->type = $type;
        $this->isVariadic = $isVariadic;
    }
    public function getType() : \PHPStan\Type\Type
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
    public function withType(\PHPStan\Type\Type $type) : \PHPStan\PhpDoc\Tag\TypedTag
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
