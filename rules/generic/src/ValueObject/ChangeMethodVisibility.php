<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Generic\ValueObject;

final class ChangeMethodVisibility
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $visibility;
    public function __construct(string $class, string $method, string $visibility)
    {
        $this->class = $class;
        $this->method = $method;
        $this->visibility = $visibility;
    }
    public function getClass() : string
    {
        return $this->class;
    }
    public function getMethod() : string
    {
        return $this->method;
    }
    public function getVisibility() : string
    {
        return $this->visibility;
    }
}
