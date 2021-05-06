<?php

declare (strict_types=1);
namespace Rector\Removing\ValueObject;

final class RemoveFuncCall
{
    /**
     * @var string
     */
    private $funcCall;
    /**
     * @var mixed[]
     */
    private $argumentPositionAndValues;
    /**
     * @param array<int, mixed[]> $argumentPositionAndValues
     */
    public function __construct(
        string $funcCall,
        /**
         * @var array<int, mixed[]>
         */
        array $argumentPositionAndValues = []
    )
    {
        $this->funcCall = $funcCall;
        $this->argumentPositionAndValues = $argumentPositionAndValues;
    }
    public function getFuncCall() : string
    {
        return $this->funcCall;
    }
    /**
     * @return array<int, mixed[]>
     */
    public function getArgumentPositionAndValues() : array
    {
        return $this->argumentPositionAndValues;
    }
}
