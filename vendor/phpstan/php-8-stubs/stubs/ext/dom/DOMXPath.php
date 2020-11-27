<?php

namespace _PhpScoperbd5d0c5f7638;

#ifdef LIBXML_XPATH_ENABLED
class DOMXPath
{
    public function __construct(\DOMDocument $document, bool $registerNodeNS = \true)
    {
    }
    /** @return mixed */
    public function evaluate(string $expression, ?\DOMNode $contextNode = null, bool $registerNodeNS = \true)
    {
    }
    /** @return mixed */
    public function query(string $expression, ?\DOMNode $contextNode = null, bool $registerNodeNS = \true)
    {
    }
    /** @return bool */
    public function registerNamespace(string $prefix, string $namespace)
    {
    }
    /** @return void */
    public function registerPhpFunctions(string|array|null $restrict = null)
    {
    }
}
#ifdef LIBXML_XPATH_ENABLED
\class_alias('_PhpScoperbd5d0c5f7638\\DOMXPath', 'DOMXPath', \false);
