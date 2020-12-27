<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc\Tag;

use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Type;
class TemplateTag
{
    /** @var string */
    private $name;
    /** @var \PHPStan\Type\Type */
    private $bound;
    /** @var TemplateTypeVariance */
    private $variance;
    public function __construct(string $name, \PHPStan\Type\Type $bound, \PHPStan\Type\Generic\TemplateTypeVariance $variance)
    {
        $this->name = $name;
        $this->bound = $bound;
        $this->variance = $variance;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getBound() : \PHPStan\Type\Type
    {
        return $this->bound;
    }
    public function getVariance() : \PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->variance;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['name'], $properties['bound'], $properties['variance']);
    }
}
