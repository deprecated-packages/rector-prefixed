<?php

namespace _PhpScopera143bcca66cb;

class SoapServer
{
    public function __construct(?string $wsdl, array $options = [])
    {
    }
    /** @return void */
    public function fault(string $code, string $string, string $actor = "", mixed $details = null, string $name = "")
    {
    }
    /** @return void */
    public function addSoapHeader(\SoapHeader $header)
    {
    }
    /** @return void */
    public function setPersistence(int $mode)
    {
    }
    /** @return void */
    public function setClass(string $class, mixed ...$args)
    {
    }
    /** @return void */
    public function setObject(object $object)
    {
    }
    /** @return array */
    public function getFunctions()
    {
    }
    /**
     * @param array|string|int $functions
     * @return void
     */
    public function addFunction($functions)
    {
    }
    /** @return void */
    public function handle(?string $request = null)
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\SoapServer', 'SoapServer', \false);
