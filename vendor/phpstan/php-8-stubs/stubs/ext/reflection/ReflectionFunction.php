<?php

namespace _PhpScoper26e51eeacccf;

class ReflectionFunction extends \ReflectionFunctionAbstract
{
    public function __construct(Closure|string $function)
    {
    }
    public function __toString() : string
    {
    }
    /**
     * @return bool
     * @deprecated ReflectionFunction can no longer be constructed for disabled functions
     */
    public function isDisabled()
    {
    }
    /** @return mixed */
    public function invoke(mixed ...$args)
    {
    }
    /** @return mixed */
    public function invokeArgs(array $args)
    {
    }
    /** @return Closure */
    public function getClosure()
    {
    }
}
\class_alias('_PhpScoper26e51eeacccf\\ReflectionFunction', 'ReflectionFunction', \false);
