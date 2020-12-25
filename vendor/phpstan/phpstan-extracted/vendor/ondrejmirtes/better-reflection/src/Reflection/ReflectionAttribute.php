<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection;

class ReflectionAttribute
{
    /** @var string */
    private $name;
    /** @var mixed[] */
    private $arguments;
    /**
     * @param mixed[] $arguments
     */
    public function __construct(string $name, array $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return mixed[]
     */
    public function getArguments() : array
    {
        return $this->arguments;
    }
    /**
     * @return object
     */
    public function newInstance()
    {
        $class = $this->name;
        return new $class(...$this->arguments);
    }
}
