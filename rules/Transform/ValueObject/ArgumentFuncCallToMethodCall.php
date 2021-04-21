<?php

declare (strict_types=1);
namespace Rector\Transform\ValueObject;

final class ArgumentFuncCallToMethodCall
{
    /**
     * @var string
     */
    private $function;
    /**
     * @var string
     */
    private $class;
    /**
     * @var string|null
     */
    private $methodIfNoArgs;
    /**
     * @var string|null
     */
    private $methodIfArgs;
    /**
     * @param string|null $methodIfArgs
     * @param string|null $methodIfNoArgs
     */
    public function __construct(string $function, string $class, $methodIfArgs = null, $methodIfNoArgs = null)
    {
        $this->function = $function;
        $this->class = $class;
        $this->methodIfArgs = $methodIfArgs;
        $this->methodIfNoArgs = $methodIfNoArgs;
    }
    public function getFunction() : string
    {
        return $this->function;
    }
    public function getClass() : string
    {
        return $this->class;
    }
    /**
     * @return string|null
     */
    public function getMethodIfNoArgs()
    {
        return $this->methodIfNoArgs;
    }
    /**
     * @return string|null
     */
    public function getMethodIfArgs()
    {
        return $this->methodIfArgs;
    }
}
