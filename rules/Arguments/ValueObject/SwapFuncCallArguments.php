<?php

declare (strict_types=1);
namespace Rector\Arguments\ValueObject;

final class SwapFuncCallArguments
{
    /**
     * @var string
     */
    private $function;
    /**
     * @var mixed[]
     */
    private $order;
    /**
     * @param int[] $order
     */
    public function __construct(
        string $function,
        /**
         * @var array<int, int>
         */
        array $order
    )
    {
        $this->function = $function;
        $this->order = $order;
    }
    public function getFunction() : string
    {
        return $this->function;
    }
    /**
     * @return array<int, int>
     */
    public function getOrder() : array
    {
        return $this->order;
    }
}
