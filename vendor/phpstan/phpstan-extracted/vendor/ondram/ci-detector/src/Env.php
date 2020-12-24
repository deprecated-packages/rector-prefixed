<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\OndraM\CiDetector;

/**
 * Encapsulate access to the environment variables
 */
class Env
{
    /**
     * @return string|false Environment variable value or false if the variable does not exist
     */
    public function get(string $name)
    {
        return \getenv($name);
    }
    public function getString(string $name) : string
    {
        return (string) $this->get($name);
    }
}
