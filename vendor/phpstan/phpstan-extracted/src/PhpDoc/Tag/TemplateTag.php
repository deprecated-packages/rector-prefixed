<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\Tag;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class TemplateTag
{
    /** @var string */
    private $name;
    /** @var \PHPStan\Type\Type */
    private $bound;
    /** @var TemplateTypeVariance */
    private $variance;
    public function __construct(string $name, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $bound, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $variance)
    {
        $this->name = $name;
        $this->bound = $bound;
        $this->variance = $variance;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getBound() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->bound;
    }
    public function getVariance() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance
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
