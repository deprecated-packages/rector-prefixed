<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order\ValueObject;

use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Order\Contract\RankeableInterface;
final class PropertyRankeable implements \_PhpScoper0a6b37af0871\Rector\Order\Contract\RankeableInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $visibility;
    /**
     * @var int
     */
    private $position;
    /**
     * @var Property
     */
    private $property;
    public function __construct(string $name, int $visibility, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property $property, int $position)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->property = $property;
        $this->position = $position;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return bool[]|int[]
     */
    public function getRanks() : array
    {
        return [$this->visibility, $this->property->isStatic(), $this->position];
    }
}
