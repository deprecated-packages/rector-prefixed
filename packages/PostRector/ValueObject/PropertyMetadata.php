<?php

declare (strict_types=1);
namespace Rector\PostRector\ValueObject;

use PHPStan\Type\Type;
final class PropertyMetadata
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Type|null
     */
    private $type;
    /**
     * @var int
     */
    private $flags;
    /**
     * @param \PHPStan\Type\Type|null $type
     */
    public function __construct(string $name, $type, int $flags)
    {
        $this->name = $name;
        $this->type = $type;
        $this->flags = $flags;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return \PHPStan\Type\Type|null
     */
    public function getType()
    {
        return $this->type;
    }
    public function getFlags() : int
    {
        return $this->flags;
    }
}
