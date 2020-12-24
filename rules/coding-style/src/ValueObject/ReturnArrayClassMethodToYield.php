<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\ValueObject;

final class ReturnArrayClassMethodToYield
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $method;
    public function __construct(string $type, string $method)
    {
        $this->type = $type;
        $this->method = $method;
    }
    public function getType() : string
    {
        return $this->type;
    }
    public function getMethod() : string
    {
        return $this->method;
    }
}
