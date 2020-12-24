<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\Tests\Rector\MethodCall\FluentChainMethodCallToNormalMethodCallRector\Source;

interface SomeResponse
{
    /**
     * Sends a HTTP header and replaces a previous one.
     * @param  string  header name
     * @param  string  header value
     * @return static
     */
    function setHeader($name, $value);
}
