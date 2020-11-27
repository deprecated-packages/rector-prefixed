<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\ReflectionFunction', 'ReflectionFunction', \false);
