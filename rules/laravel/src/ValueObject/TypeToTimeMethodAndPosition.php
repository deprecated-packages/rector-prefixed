<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Laravel\ValueObject;

final class TypeToTimeMethodAndPosition
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var int
     */
    private $position;
    public function __construct(string $type, string $methodName, int $position)
    {
        $this->type = $type;
        $this->methodName = $methodName;
        $this->position = $position;
    }
    public function getType() : string
    {
        return $this->type;
    }
    public function getMethodName() : string
    {
        return $this->methodName;
    }
    public function getPosition() : int
    {
        return $this->position;
    }
}
