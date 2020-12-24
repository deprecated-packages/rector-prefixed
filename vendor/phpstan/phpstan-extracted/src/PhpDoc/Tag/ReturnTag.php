<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class ReturnTag implements \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\TypedTag
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $isExplicit;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $isExplicit)
    {
        $this->type = $type;
        $this->isExplicit = $isExplicit;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
    public function withType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\TypedTag
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
