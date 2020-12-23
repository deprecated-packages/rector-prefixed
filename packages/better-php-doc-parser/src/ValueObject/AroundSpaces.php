<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject;

final class AroundSpaces
{
    /**
     * @var string
     */
    private $closingSpace;
    /**
     * @var string
     */
    private $openingSpace;
    public function __construct(string $closingSpace, string $openingSpace)
    {
        $this->closingSpace = $closingSpace;
        $this->openingSpace = $openingSpace;
    }
    public function getClosingSpace() : string
    {
        return $this->closingSpace;
    }
    public function getOpeningSpace() : string
    {
        return $this->openingSpace;
    }
}
