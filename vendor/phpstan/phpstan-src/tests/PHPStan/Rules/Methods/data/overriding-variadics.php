<?php

namespace _PhpScopera143bcca66cb\OverridingVariadics;

interface ITranslator
{
    /**
     * Translates the given string.
     * @param  mixed  $message
     * @param  string  ...$parameters
     */
    function translate($message, string ...$parameters) : string;
}
class Translator implements \_PhpScopera143bcca66cb\OverridingVariadics\ITranslator
{
    /**
     * @param string $message
     * @param string ...$parameters
     */
    public function translate($message, $lang = 'cs', string ...$parameters) : string
    {
    }
}
class OtherTranslator implements \_PhpScopera143bcca66cb\OverridingVariadics\ITranslator
{
    public function translate($message, $lang, string ...$parameters) : string
    {
    }
}
class AnotherTranslator implements \_PhpScopera143bcca66cb\OverridingVariadics\ITranslator
{
    public function translate($message, $lang = 'cs', string $parameters) : string
    {
    }
}
class YetAnotherTranslator implements \_PhpScopera143bcca66cb\OverridingVariadics\ITranslator
{
    public function translate($message, $lang = 'cs') : string
    {
    }
}
class ReflectionClass extends \ReflectionClass
{
    public function newInstance($arg = null, ...$args)
    {
    }
}
