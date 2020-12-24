<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class VarTag implements \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\TypedTag
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
     * @param Type $type
     * @return self
     */
    public function withType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\Tag\TypedTag
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
