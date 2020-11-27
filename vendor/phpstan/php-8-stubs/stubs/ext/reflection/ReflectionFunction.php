<?php

namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\ReflectionFunction', 'ReflectionFunction', \false);
