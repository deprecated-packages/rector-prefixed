<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject;

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
