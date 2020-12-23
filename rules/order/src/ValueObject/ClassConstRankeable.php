<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Order\ValueObject;

use _PhpScoper0a2ac50786fa\Rector\Order\Contract\RankeableInterface;
final class ClassConstRankeable implements \_PhpScoper0a2ac50786fa\Rector\Order\Contract\RankeableInterface
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
    public function __construct(string $name, int $visibility, int $position)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->position = $position;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * An array to sort the element order by
     * @return int[]
     */
    public function getRanks() : array
    {
        return [$this->visibility, $this->position];
    }
}
