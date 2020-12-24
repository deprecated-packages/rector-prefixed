<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Order\ValueObject;

final class PropertyNameRankAndPosition
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $rank;
    /**
     * @var int
     */
    private $position;
    public function __construct(string $name, int $rank, int $position)
    {
        $this->name = $name;
        $this->rank = $rank;
        $this->position = $position;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getRank() : int
    {
        return $this->rank;
    }
    public function getPosition() : int
    {
        return $this->position;
    }
}
